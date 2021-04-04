<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setFirstName('Arnold');
        $admin->setLastName('Schwarz');
        $admin->setEmail("vlad.svizinskiy@mail.ru");
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        $admin->setPin('0500');
        $admin->setDefaultLanguage('en');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin, 'admin1'
        ));
        $manager->persist($admin);
        $manager->flush();
    }
}
