<?php

namespace App\Security\Voter;

use App\Entity\Profile;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;


class VoterPage extends Voter
{

    const MAIN_ACCESS = 'MAIN_ACCESS';
    const ADD_ACCESS = 'ADD_ACCESS';
    const SHOW_ACCESS = 'SHOW_ACCESS';
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, array(self::MAIN_ACCESS, self::ADD_ACCESS, self::SHOW_ACCESS))) {
            return false;
        }
        if (!$subject) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        switch ($attribute) {
            case self::ADD_ACCESS:
                return $this->canAddProfile($subject, $user);
            case self::MAIN_ACCESS:
                return $this->canShowMainContent($subject);
            case self::SHOW_ACCESS:
                return $this->giveAccessToShow($subject);
        }
        throw new \LogicException('This code');
    }

    public function canAddProfile($pin, $user): bool
    {
        if ($pin === $user->getPin()) {
            return true;
        }
        return false;
    }

    public function canShowMainContent($requestedData): bool
    {
        $pin = $requestedData['enteredPin'];
        $profilePin = $requestedData['profilePin'];

        if ($pin === $profilePin) {
            return true;
        }
        if ($profilePin === null) {
            return true;
        }
        return false;
    }

    public function giveAccessToShow($dataToCheck)
    {
        $profileAgeCategory = $dataToCheck['profileAgeCategory'];
        $contentAgeCategory = $dataToCheck['contentAgeCategory'];
        if ($profileAgeCategory === null && $contentAgeCategory === null) {
            return true;
        }
        if ($profileAgeCategory === false && ($contentAgeCategory === null || $contentAgeCategory === false)) {
            return true;
        }
        if ($profileAgeCategory === true) {
            return true;
        }
        return false;
    }

}