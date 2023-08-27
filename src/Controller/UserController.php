<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function index(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {

        if (!$this->getUser()) {
            dd($this->getUser());
            $this->addFlash(
                'danger',
                "You are not connected"
            );
            return $this->redirectToRoute('login.index');
        }
        if ($this->getUser() !== $user) {
            $this->addFlash(
                'danger',
                "You can't edit this user"
            );
            return $this->redirectToRoute('login.index');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordHasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "User account informations has been updated"
                );

                return $this->redirectToRoute('player.index');
            } else {
                $this->addFlash(
                    'danger',
                    "Password is not valid"
                );
            }
        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/password/{id}', name: 'user.password', methods: ['GET', 'POST'])]
    public function editPassword(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {

        if (!$this->getUser()) {
            dd($this->getUser());
            $this->addFlash(
                'danger',
                "You are not connected"
            );
            return $this->redirectToRoute('login.index');
        }
        if ($this->getUser() !== $user) {
            $this->addFlash(
                'danger',
                "You can't edit this user"
            );
            return $this->redirectToRoute('login.index');
        }

        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordHasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setPlainPassword(
                    $form->getData()['newPassword']
                );

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "User password has been updated"
                );

                return $this->redirectToRoute('player.index');
            } else {
                $this->addFlash(
                    'danger',
                    "Password is not valid"
                );
            }
        }

        return $this->render('pages/user/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
