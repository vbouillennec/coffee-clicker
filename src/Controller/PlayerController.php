<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
	#[Route('/players', name: 'player.index', methods: ['GET'])]
	public function index(PlayerRepository $playerRepo, PaginatorInterface $paginator, Request $request): Response
	{
		$players = $paginator->paginate(
			$playerRepo->findAll(),
			$request->query->getInt('page', 1),
			10,
			[
				'defaultSortFieldName' => 'createdAt',
				'defaultSortDirection' => 'desc'
			]
		);
		return $this->render('pages/player/index.html.twig', [
			'players' => $players,
		]);
	}

	#[Route('/player/new', name: 'player.new', methods: ['GET', 'POST'])]
	public function new(Request $request, EntityManagerInterface $manager): Response
	{
		$player = new Player();
		$form = $this->createForm(PlayerType::class, $player);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$player = $form->getData();

			$manager->persist($player);
			$manager->flush();

			$pseudo = $player->getPseudo();
			$this->addFlash(
				'success',
				"Player $pseudo created successfully"
			);

			return $this->redirectToRoute('player.index');
		}

		return $this->render('pages/player/new.html.twig', ['form' => $form->createView()]);
	}

	#[Route('/player/edit/{id}', name: 'player.edit', methods: ['GET', 'POST'])]
	public function edit(
		Player $player,
		Request $request,
		EntityManagerInterface $manager
	): Response {
		$form = $this->createForm(PlayerType::class, $player);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$player = $form->getData();

			$manager->persist($player);
			$manager->flush();

			$pseudo = $player->getPseudo();
			$this->addFlash(
				'success',
				"Player $pseudo successfully updated"
			);

			return $this->redirectToRoute('player.index');
		}

		return $this->render('pages/player/edit.html.twig', ['form' => $form->createView()]);
	}

	#[Route('/player/delete/{id}', name: 'player.delete', methods: ['GET'])]
	public function delete(
		Player $player,
		EntityManagerInterface $manager
	): Response {
		if (!$player) {
			// throw $this->createNotFoundException('Player not found');
			$this->addFlash(
				'warning',
				"Players doesn't exist"
			);
			return $this->redirectToRoute('player.index');
		}

		$pseudo = $player->getPseudo();
		$manager->remove($player);
		$manager->flush();

		$this->addFlash(
			'success',
			"Player $pseudo successfully deleted"
		);

		return $this->redirectToRoute('player.index');
	}
}
