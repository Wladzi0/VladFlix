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
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, array(self::MAIN_ACCESS))) {
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
//            case self::ADD:
//                return $this->canShow($subject, $user);
            case self::MAIN_ACCESS:
                return $this->canShow($subject);
        }
        throw new \LogicException('This code');
    }

    public function canShow($requestedData): bool
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

}