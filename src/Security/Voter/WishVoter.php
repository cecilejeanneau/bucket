<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Wish;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class WishVoter extends Voter
{
    public const EDIT = 'WISH_EDIT';
//    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT])
            && $subject instanceof \App\Entity\Wish;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                break;

            case self::EDIT:
                return $this->canEditWish($subject, $user);
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }

    public function canEditWish(Wish $subject, User $user): bool
    {
        if($user === $subject->getUser()) {
            return true;
        }

        if(in_array("ROLE_ADMIN", $user->getRoles())) {
            return true;
        }

        return false;
    }
}
