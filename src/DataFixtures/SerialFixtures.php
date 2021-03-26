<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Film;
use App\Entity\Season;
use App\Entity\Serial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class   SerialFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
//        $serial1=$manager->find("Serial",20);
//        $seasonTF1=new Season();
//        $seasonTF1->setSerial($serial1);
//        $manager->marge($seasonTF1);
//        $manager->flush();
    }
}
