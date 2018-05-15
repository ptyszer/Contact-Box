<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Address;
use ContactBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    /**
     * @Route("/{id}/addAddress")
     */
    public function addAction(Request $request, $id)
    {
        $address = new Address();
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['id' => $id]);

        $formAddress = $this->createForm('ContactBundle\Form\AddressType', $address);
        $formAddress->handleRequest($request);

        if ($formAddress->isSubmitted() && $formAddress->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address->setPerson($person));
            $em->flush();
            return $this->redirectToRoute('contact_person_modifyget', ['id' => $person->getId()]);
        }
        return new Response('<html><body>Błąd</body></html>');
    }

    /**
     * @Route("/deleteAddress/{id}", methods={"DELETE"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository(Address::class)->findOneBy(['id' => $id]);
        $em->remove($address);
        $em->flush();

        return new JsonResponse('done');
    }

}
