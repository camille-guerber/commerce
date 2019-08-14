<?php

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        // TODO: Implement checkPreAuth() method.
        if(!$user instanceof User) {
            return;
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
        if(!$user instanceof User) {
            return;
        }

        if(!$user->getIsActive()) {
            throw new \Exception("Ce membre n'est pas actif");
        }
    }
}