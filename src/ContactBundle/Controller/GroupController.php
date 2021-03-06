<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\ContactGroup;
use ContactBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/group")
 */
class GroupController extends Controller
{
    /**
     * @Route("/new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $group = new ContactGroup();
        $form = $this->createFormBuilder($group)
            ->setMethod('POST')
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Add group', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
            return $this->redirectToRoute('contact_group_showsingle', ['id' => $group->getId()]);
        }

        return $this->render('@Contact/Group/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{group}/removePerson/{person}")
     */
    public function removePersonAction(ContactGroup $group, Person $person)
    {
        $person->removeGroup($group);
        $em = $this->getDoctrine()->getManager();
        $em->persist($person);
        $em->flush();

        return $this->redirectToRoute('contact_group_showsingle', ['id' => $group->getId()]);
    }

    /**
     * @Route("/{id}/delete")
     */
    public function deleteAction(ContactGroup $group)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        return $this->render('@Contact/Group/delete.html.twig', array());
    }


    /**
     * @Route("/{id}")
     */
    public function showSingleAction(ContactGroup $group)
    {
        return $this->render('@Contact/Group/show_single.html.twig', array('group' => $group));
    }

    /**
     * @Route("/")
     */
    public function showAllAction()
    {
        $groups = $this->getDoctrine()->getRepository(ContactGroup::class)->findBy([], ['name' => 'ASC']);
        return $this->render('@Contact/Group/show_all.html.twig', array('groups' => $groups));
    }
}
