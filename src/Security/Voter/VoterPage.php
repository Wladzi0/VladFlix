<?php

namespace App\Security\Voter;

use App\Entity\Profile;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;


class VoterPage extends Voter
{

    const SHOW = 'SHOW';
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
//                return $this->canAdd($subject, $user);
            case self::SHOW:
                return$this->canShow($subject);
        }
        throw new \LogicException('This code');
}

    public function canShow($pin): bool
    {
        if($pin){
        return true;
    }
        return false;
    }

}