<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/asdasd", )
     */
    public function indexAction(Request $request)
    {
        // loading homapage
        return new Response('Hello');
    }

    /**
     * @Route("/add")
     */
    public function createAction()
    {
        // fetching the EntityManager via $this->getDoctrine()
        $entityManager = $this->getDoctrine()->getManager();

        $contact = new Contact();
        $contact->setFirstname('MD Symun');
        $contact->setLastname('Istehad');
        $contact->setPhone('015751365896');
        $contact->setEmail('symun91@gmail.com');
        $contact->setStreet('Hausen 90');
        $contact->setCity('FFM');
        $contact->setCountry('Germany');
        $contact->setDob(new \DateTime('01/01/1992'));
        $contact->setZip('60488');
        $contact->setPicture('assets/pic/1.jpg');



        // Saving the contact information
        $entityManager->persist($contact);

        // actually executes the queries
        $entityManager->flush();

        return new Response('Saved new product with id '.$contact->getId());
    }
}
