<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/admin/users', name: 'user.index', methods: ['GET'])]
    public function index(UserRepository $userRepo, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $paginator->paginate(
            $userRepo->findAll(),
            $request->query->getInt('page', 1),
            10,
            [
                'defaultSortFieldName' => 'createdAt',
                'defaultSortDirection' => 'asc'
            ]
        );
        return $this->render('pages/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{username}/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'user', 'Your not allowed to edit this user')]
    public function edit(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordHasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $user->setUpdatedAt(new \DateTimeImmutable());

                $manager->persist($user);
                $manager->flush();

                $user->setImageFile(null);

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
            'username' => $user->getUsername(),
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/{username}/password', name: 'user.password', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'user')]
    public function editPassword(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordHasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setPlainPassword(
                    $form->getData()['newPassword']
                );
                $user->setUpdatedAt(new \DateTimeImmutable());

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
            'username' => $user->getUsername(),
            'form' => $form->createView()
        ]);
    }
}
