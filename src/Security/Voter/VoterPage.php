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

    const SHOW = 'SHOW';
    const ADD = 'ADD';
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, array(self::SHOW))) {
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
            case self::SHOW:
                return $this->canShow($subject);
        }
        throw new \LogicException('This code');
    }

    public function canShow($dataProfile): bool
    {
//       var_dump($dataProfile);

        $pin = $dataProfile[0];
        $profilePin = $dataProfile[1];
//        var_dump($pin === $profilePin);
//        die;
        if ($pin === $profilePin) {
            return true;
        }
        if ($profilePin === null) {
            return true;
        }
        return false;
    }

}