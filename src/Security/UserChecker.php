<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    private $urlGenerator;


    public function __construct(UrlGeneratorInterface $urlGenerator)
    {

        $this->urlGenerator = $urlGenerator;

    }
public function checkPreAuth(UserInterface $user)
{
if (!$user instanceof AppUser) {
return;
}

if ($user->isVerified()==false) {
// the message passed to this exception is meant to be displayed to the user
throw new CustomUserMessageAccountStatusException('Your user account is not activated');
}
//else {
//    return new RedirectResponse($this->urlGenerator->generate('choose_profile'));
//}

}

public function checkPostAuth(UserInterface $user)
{
if (!$user instanceof AppUser) {
return;
}


}
}