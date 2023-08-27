<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
  private UserPasswordHasherInterface $passwordHasher;

  public function __construct(UserPasswordHasherInterface $passwordHasher)
  {
    $this->passwordHasher = $passwordHasher;
  }

  public function prePersist(User $user): void
  {
    $this->encodePassword($user);
  }

  public function preUpdate(User $user): void
  {
    $this->encodePassword($user);
  }

  public function encodePassword(User $user): void
  {
    if (!$user->getPlainPassword()) {
      return;
    }

    $hashPassword = $this->passwordHasher->hashPassword(
      $user,
      $user->getPlainPassword()
    );
    $user->setPassword($hashPassword);

    $user->setPlainPassword(null);
  }
}
