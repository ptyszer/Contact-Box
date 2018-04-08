<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

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

//        $formFirstName = $request->get('firstName');
//        $formLastName = $request->get('lastName');
//        $description = $request->get('description');

//        $person->setFirstName($formFirstName);
//        $person->setLastName($formLastName);
//        $person->setDescription($description);
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($person);
//        $em->flush();

    }

    /**
     * @Route("/{id}/modify", methods={"GET"})
     */
    public function modifyGetAction($id)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);

        $form = $this->createFormBuilder($person)
            ->setMethod('POST')
            ->add('firstName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('lastName', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Add Person', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        return $this->render('@Contact/Person/modify.html.twig', array('form' => $form->createView()));
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

//        return $this->redirectToRoute('contact_person_showsingle', ['id' => $person->getId()]);
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

}
