<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $requestedUser = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canView($requestedUser, $user);
                break;
            case self::VIEW:
                return $this->canView($requestedUser, $user);
                break;
        }

        return false;
    }

    private function canView(User $requestedUser, User $user): bool
    {
        // if they can edit, they can view
        return $this->canEdit($requestedUser, $user);
    }

    private function canEdit(User $requestedUser, User $user): bool
    {
        // this assumes that the Post object has a `getOwner()` method
        return $user->isSameUser($requestedUser);
    }
}
