<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class HomeController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        // loading homapage
        return $this->redirectToRoute("contact_list");
    }

    /**
     * @Route("contact/list" , name = "contact_list")
     */
    public function viewContactList(Request $request){
        // loading
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        return $this->render('default/list.html.twig', array('contacts'=> $contacts));
    }

    /**
     * @Route("contact/details/{id}")
     */
    public function showDetails(Request $request, $id){
        // loading
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
        return $this->render('default/details.html.twig', array('contact'=> $contact));
    }

    /**
     * @Route("/contact/new", name= "new_contact")
     * Method({"GET", "POST"})
     */
    public function new(Request $request){

        $contact = new Contact();

        $form = $this->createForm(ContactType::class,$contact, array('label' => 'Save'));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('picture')->getData();
            $fileName = time().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            $contact->setPicture($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute("contact_list");
        }

        return $this->render('default/edit.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/contact/edit/{id}", name= "edit_contact")
     * Method({"GET", "POST"})
     */

    public function edit(Request $request, $id){


        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

        $form = $this->createForm(ContactType::class,$contact, array('label' => 'Update'));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contact = $form->getData();
            $oldFileName = $contact->getPicture();
            $oldFilePath = $this->getParameter('image_directory').'/'.$oldFileName;

            /** @var UploadedFile $file */
            $file = $form->get('picture')->getData();

            // Edit picture
            if($file!=null){

                // Removing old file
                $fileSystem = new Filesystem();
                $fileSystem->remove($oldFilePath);

                // Storing new file
                $fileName = time().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );
                $contact->setPicture($fileName);
            }else{
                $contact->setPicture($oldFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute("contact_list");
        }

        return $this->render('default/new.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/contact/delete/{id}")
     * Method({"DELETE"})
     */

    public function delete(Request $request, $id){
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

        // Removing file
        $oldFileName = $contact->getPicture();
        $oldFilePath = $this->getParameter('image_directory').'/'.$oldFileName;
        $fileSystem = new Filesystem();
        $fileSystem->remove(array($oldFilePath));

        // Removing post
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


}