<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private int $id;

	#[ORM\Column(type: TYPES::STRING, length: 50, nullable: true)]
	#[Assert\Length(max: 50)]
	private ?string $fullName = null;

	#[ORM\Column(type: TYPES::STRING, length: 50)]
	#[Assert\Email(
		message: 'The email {{ value }} is not a valid email.',
	)]
	private string $email;

	#[ORM\Column(type: TYPES::STRING, length: 100, nullable: true)]
	private ?string $subject = null;

	#[ORM\Column(type: Types::TEXT)]
	#[Assert\NotBlank()]
	private string $message;

	#[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
	#[Assert\NotNull]
	private \DateTimeImmutable $createdAt;

	public function __construct()
	{
		$this->createdAt = new \DateTimeImmutable();
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	public function setFullName(string $fullName): static
	{
		$this->fullName = $fullName;

		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): static
	{
		$this->email = $email;

		return $this;
	}

	public function getSubject(): ?string
	{
		return $this->subject;
	}

	public function setSubject(?string $subject): static
	{
		$this->subject = $subject;

		return $this;
	}

	public function getMessage(): string
	{
		return $this->message;
	}

	public function setMessage(string $message): static
	{
		$this->message = $message;

		return $this;
	}

	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeImmutable $createdAt): static
	{
		$this->createdAt = $createdAt;

		return $this;
	}
}
