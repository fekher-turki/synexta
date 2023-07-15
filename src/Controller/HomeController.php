<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(EntityManagerInterface $manager, Request $request,): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contact = $contactForm->getData();
            $email = $contact->getEmail();
            $existingEmail = $manager->getRepository(Contact::class)->findOneBy(['email' => $email]);
            if ($existingEmail) {
                $contactForm->get('email')->addError(new FormError('Cet e-mail déjà existe.'));
            } else {
                $manager->persist($contact);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre requête a été envoyée avec succès'
                );

                return $this->redirectToRoute('home.index');
            }
        }

        return $this->render('pages/home/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
