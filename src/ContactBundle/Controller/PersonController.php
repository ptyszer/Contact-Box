<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Address;
use ContactBundle\Entity\ContactGroup;
use ContactBundle\Entity\Email;
use ContactBundle\Entity\Person;
use ContactBundle\Entity\Phone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function showAllAction()
    {
        $persons = $this->getDoctrine()->getRepository(Person::class)->findBy([], ['firstName' => 'ASC']);
        return $this->render('@Contact/Person/show_all.html.twig', array('persons' => $persons));
    }

    /**
     * @Route("contact/new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $person = new Person();
        $form = $this->createForm('ContactBundle\Form\PersonType', $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute('contact_person_showsingle', ['id' => $person->getId()]);
        }

        return $this->render('@Contact/Person/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/addGroup", methods={"POST"})
     */
    public function addGroupAction(Request $request)
    {
        $groupId = $request->get('group_id');
        $personId = $request->get('person_id');
        $group = $this->getDoctrine()->getRepository(ContactGroup::class)->findOneBy(['id' => $groupId]);
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $personId]);

        $person->addGroup($group);
        $em = $this->getDoctrine()->getManager();
        $em->persist($person);
        $em->flush();

        return $this->redirectToRoute('contact_person_modifyget', ['id' => $person->getId()]);
    }

    /**
     * @Route("/{id}/modify", methods={"GET"})
     */
    public function modifyGetAction($id)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);
        $groups = $this->getDoctrine()->getRepository(ContactGroup::class)->findAll();
        $address = new Address();
        $email = new Email();
        $phone = new Phone();

        $formPerson = $this->createForm('ContactBundle\Form\PersonType', $person);
        $formAddress = $this->createForm('ContactBundle\Form\AddressType', $address,
            array( 'action' => '/'.$person->getId().'/addAddress'));
        $formEmail = $this->createForm('ContactBundle\Form\EmailFormType', $email,
            array( 'action' => '/'.$person->getId().'/addEmail'));
        $formPhone = $this->createForm('ContactBundle\Form\PhoneType', $phone,
            array( 'action' => '/'.$person->getId().'/addPhone'));

        return $this->render('@Contact/Person/modify.html.twig', array(
            'person' => $person,
            'formPerson' => $formPerson->createView(),
            'formAddress' => $formAddress->createView(),
            'formEmail' => $formEmail->createView(),
            'formPhone' => $formPhone->createView(),
            'groups' => $groups
        ));
    }

    /**
     * @Route("/{id}/modify", methods={"POST"})
     */
    public function modifyPostAction(Request $request, $id)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);
        $form = $this->createForm('ContactBundle\Form\PersonType', $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            return $this->redirectToRoute('contact_person_showsingle', ['id' => $person->getId()]);
        }

    }

    /**
     * @Route("/{id}/delete")
     */
    public function deleteAction(Person $person)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        return $this->render('@Contact/Person/delete.html.twig', array());
    }

    /**
     * @Route("contact/{id}")
     */
    public function showSingleAction(Person $person)
    {
        return $this->render('@Contact/Person/show_single.html.twig', array('person' => $person));
    }

    /**
     * @Route("/", methods={"POST"})
     */
    public function searchAction(Request $request)
    {
        $string = $request->get('search');
        $persons = $this->getDoctrine()->getRepository(Person::class)->search($string);
        return $this->render('@Contact/Person/search_result.html.twig', array('persons' => $persons));
    }
}
