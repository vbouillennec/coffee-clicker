<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[UniqueEntity(fields: 'pseudo', message: 'There is already a player with this {{ label }}')]
#[UniqueEntity(fields: 'email', message: 'There is already a player with this {{ label }}')]
class Player
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(type: 'string', length: 50)]
	#[Assert\NotBlank(message: 'Please enter your pseudo')]
	#[Assert\Length(
		min: 3,
		max: 50,
		minMessage: 'Your pseudo must be at least {{ limit }} characters long',
		maxMessage: 'Your pseudo cannot be longer than {{ limit }} characters',
	)]
	private ?string $pseudo = null;

	#[ORM\Column(type: 'string', length: 50)]
	#[Assert\NotBlank(message: 'Please enter your email')]
	#[Assert\Email(
		message: 'The email {{ value }} is not a valid email.',
	)]
	private ?string $email = null;

	#[ORM\Column(type: 'integer', nullable: true)]
	#[Assert\PositiveOrZero]
	private ?int $totalPoints = null;

	#[ORM\Column(type: 'datetime_immutable')]
	#[Assert\NotNull]
	private ?\DateTimeImmutable $createdAt = null;

	public function __construct()
	{
		$this->createdAt = new \DateTimeImmutable();
		$this->totalPoints = 0;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getPseudo(): ?string
	{
		return $this->pseudo;
	}

	public function setPseudo(string $pseudo): static
	{
		$this->pseudo = $pseudo;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): static
	{
		$this->email = $email;

		return $this;
	}

	public function getTotalPoints(): ?int
	{
		return $this->totalPoints;
	}

	public function setTotalPoints(?int $totalPoints): static
	{
		$this->totalPoints = $totalPoints;

		return $this;
	}

	public function getCreatedAt(): ?\DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeImmutable $createdAt): static
	{
		$this->createdAt = $createdAt;

		return $this;
	}
}
