<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Phone;
use ContactBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PhoneController extends Controller
{
    /**
     * @Route("/{id}/addPhone")
     */
    public function addAction($id, Request $request)
    {
        $phone = new Phone();
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);
        $formPhone = $this->createForm('ContactBundle\Form\PhoneType', $phone);
        $formPhone->handleRequest($request);

        if ($formPhone->isSubmitted() && $formPhone->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phone->setPerson($person));
            $em->flush();
            return $this->redirectToRoute('contact_person_modifyget', ['id' => $person->getId()]);
        }
        return new Response('<html><body>Błąd</body></html>');
    }

    /**
     * @Route("/deletePhone/{id}", methods={"DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $phone = $em->getRepository(Phone::class)->findOneBy(['id' => $id]);
        $em->remove($phone);
        $em->flush();

        return new JsonResponse('done');
    }

}
