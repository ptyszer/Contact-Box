<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Address;
use ContactBundle\Entity\Email;
use ContactBundle\Entity\Person;
use ContactBundle\Entity\Phone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{
    /**
     * @Route("/new", methods={"GET"})
     */
    public function newGetAction()
    {
        $person = new Person();
        $form = $this->createFormBuilder($person)
            ->setMethod('POST')
            ->add('firstName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('lastName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Add Person', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        return $this->render('@Contact/Person/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function newPostAction(Request $request)
    {
        $person = new Person();
        $form = $this->createFormBuilder($person)
            ->setMethod('POST')
            ->add('firstName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('lastName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Add Person', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute('contact_person_showsingle', ['id' => $person->getId()]);
        }

    }

    /**
     * @Route("/{id}/modify", methods={"GET"})
     */
    public function modifyGetAction($id)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);
        $address = new Address();
        $email = new Email();
        $phone = new Phone();

        $formPerson = $this->createFormBuilder($person)
            ->setMethod('POST')
            ->add('firstName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('lastName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Edit Person', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $formAddress = $this->createFormBuilder($address)
            ->setAction($this->generateUrl('contact_person_addaddress', ['id' => $person->getId()]))
            ->setMethod('POST')
            ->add('city', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('street', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('house', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('flat', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('type', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Add address', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        return $this->render('@Contact/Person/modify.html.twig', array(
            'formPerson' => $formPerson->createView(),
            'formAddress' => $formAddress->createView(),
        ));
    }

    /**
     * @Route("/{id}/modify", methods={"POST"})
     */
    public function modifyPostAction(Request $request, $id)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);

        $form = $this->createFormBuilder($person)
            ->setMethod('POST')
            ->add('firstName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('lastName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Add Person', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute('contact_person_showsingle', ['id' => $person->getId()]);
        }

    }

    /**
     * @Route("/{id}/delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository(Person::class)->findOneBy(['id' => $id]);
        $em->remove($person);
        $em->flush();

        return $this->render('@Contact/Person/delete.html.twig', array());
    }

    /**
     * @Route("/{id}")
     */
    public function showSingleAction($id)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);

        return $this->render('@Contact/Person/show_single.html.twig', array('person' => $person));
    }

    /**
     * @Route("/")
     */
    public function showAllAction()
    {
        $persons = $this->getDoctrine()->getRepository(Person::class)->findAll();
        return $this->render('@Contact/Person/show_all.html.twig', array('persons' => $persons));
    }

    /**
     * @Route("/{id}/addAddress", methods={"POST"})
     */
    public function addAddressAction(Request $request, $id)
    {
        $address = new Address();
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);

        $formAddress = $this->createFormBuilder($address)
            ->setAction($this->generateUrl('contact_person_addaddress', ['id' => $person->getId()]))
            ->setMethod('POST')
            ->add('city', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('street', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('house', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('flat', NumberType::class, ['attr' => ['class' => 'form-control']])
            ->add('type', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Add address', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $formAddress->handleRequest($request);

        if ($formAddress->isSubmitted() && $formAddress->isValid()) {
            $address = $formAddress->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($address->setPerson($person));
            $em->flush();
            return $this->redirectToRoute('contact_person_showsingle', ['id' => $person->getId()]);
        }
        return new Response('<html><body>Błąd</body></html>');
    }
}
