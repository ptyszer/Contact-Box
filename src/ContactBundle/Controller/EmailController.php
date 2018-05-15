<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Email;
use ContactBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmailController extends Controller
{
    /**
     * @Route("/{id}/addEmail")
     */
    public function addAction($id, Request $request)
    {
        $email = new Email();
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);
        $formEmail = $this->createForm('ContactBundle\Form\EmailFormType', $email);
        $formEmail->handleRequest($request);

        if ($formEmail->isSubmitted() && $formEmail->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($email->setPerson($person));
            $em->flush();
            return $this->redirectToRoute('contact_person_modifyget', ['id' => $person->getId()]);
        }
        return new Response('<html><body>Błąd</body></html>');
    }

    /**
     * @Route("/deleteEmail/{id}", methods={"DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $email = $em->getRepository(Email::class)->findOneBy(['id' => $id]);
        $em->remove($email);
        $em->flush();

        return new JsonResponse('done');
    }

}
