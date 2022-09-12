<?php

namespace App\Controller;

use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'user_create')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        // creates a user object and initializes some data for this test
        $user = new User();
        $user->setName('');

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        // only execute this logic if its a POST form submission and if the form is valid 
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            // Save user to DB
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'sucess',
                'User was sucessfully created'
            );

            // Redirect to same page after form submission
            return $this->redirect($request->getUri());
        }

        // GET request will load users from DB and display them
        $repository = $doctrine->getRepository(User::class);
        $users = $repository->findAll();

        return $this->renderForm('user/create.html.twig', [
            'form' => $form,
            'users' => $users,
        ]);
    }
}
