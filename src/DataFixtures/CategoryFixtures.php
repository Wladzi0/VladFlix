<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\File;
use App\Entity\Film;
use App\Entity\Season;
use App\Entity\Serial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $action = new Category();
        $action->setName("Action");

        $animation = new Category();
        $animation->setName("Animation");

        $comedy = new Category();
        $comedy->setName("Comedy");

        $crime = new Category();
        $crime->setName("Crime");

        $experimental = new Category();
        $experimental->setName("Experimental");

        $fantasy = new Category();
        $fantasy->setName("Fantasy");

        $historical = new Category();
        $historical->setName("Historical");

        $horror = new Category();
        $horror->setName("Horror");

        $romance = new Category();
        $romance->setName("Romance");

        $science = new Category();
        $science->setName("Science Fiction");

        $thriller = new Category();
        $thriller->setName("Thriller");

        $western = new Category();
        $western->setName("Western");
        
        $manager->persist($action);
        $manager->persist($animation);
        $manager->persist($comedy);
        $manager->persist($crime);
        $manager->persist($experimental);
        $manager->persist($fantasy);
        $manager->persist($historical);
        $manager->persist($romance);
        $manager->persist($science);
        $manager->persist($thriller);
        $manager->persist($western);

        $manager->flush();
    }
}
