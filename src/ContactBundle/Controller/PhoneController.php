<?php

namespace ContactBundle\Controller;

use ContactBundle\Entity\Phone;
use ContactBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

        $formPhone = $this->createFormBuilder($phone, ['attr' => ['id' => 'formPhone']])
            ->setAction($this->generateUrl('contact_phone_add', ['id' => $person->getId()]))
            ->setMethod('POST')
            ->add('number', IntegerType::class, ['attr' => ['class' => 'form-control']])
            ->add('type', TextType::class, ['attr' => ['class' => 'form-control'],'required' => false])
            ->add('save', SubmitType::class, ['label' => 'Add phone number', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $formPhone->handleRequest($request);

        if ($formPhone->isSubmitted() && $formPhone->isValid()) {
            $phone = $formPhone->getData();
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
