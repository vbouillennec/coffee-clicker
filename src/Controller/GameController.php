<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/game', name: 'game.index')]
    public function index(): Response
    {
        return $this->render('pages/game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
