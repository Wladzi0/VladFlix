<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Film;
use App\Entity\Serial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $action= new Category();
        $action->setName('Action ');

        $animation= new Category();
        $animation->setName('Animation ');

        $comedy= new Category();
        $comedy->setName('Comedy ');

        $crime= new Category();
        $crime->setName('Crime ');

        $experimental= new Category();
        $experimental->setName('Experimental ');

        $fantasy= new Category();
        $fantasy->setName('Fantasy ');

        $historical= new Category();
        $historical->setName('Historical ');

        $horror= new Category();
        $horror->setName('Horror ');

        $romance= new Category();
        $romance->setName('Romance ');

        $science= new Category();
        $science->setName('Science Fiction  ');

        $thriller= new Category();
        $thriller->setName('Thriller ');

        $western= new Category();
        $western->setName('Western ');
        $first= new Film();

        $first=new Film();
        $first->setName("One Night in Miami");
        $first->setCountry('USA');
        $first->setYear(new \DateTime("01-09-2015"));
        $first->setCategory($comedy);

        $second=new Film();
        $second->setName("Toy Story 3");
        $second->setCountry('USA');
        $second->setYear(new \DateTime("01-09-2017"));
        $second->setCategory($comedy);

        $third=new Film();
        $third->setName("1917");
        $third->setCountry('USA');
        $third->setYear(new \DateTime("01-09-2020"));
        $third->setCategory($horror);

        $fourth=new Film();
        $fourth->setName("THE FAREWELL");
        $fourth->setCountry('USA');
        $fourth->setYear(new \DateTime("01-09-2013"));
        $fourth->setCategory($horror);

        $firstSerial=new Serial();
        $firstSerial->setName("THE TERROR: SEASON 1");
        $firstSerial->setCountry('USA');
        $firstSerial->setYear(new \DateTime("01-09-2015"));
        $firstSerial->setCategory($comedy);

        $secondSerial=new Serial();
        $secondSerial->setName("LUPIN: SEASON 1 ");
        $secondSerial->setCountry('USA');
        $secondSerial->setYear(new \DateTime("01-09-2018"));
        $secondSerial->setCategory($comedy);

        $thirdSerial=new Serial();
        $thirdSerial->setName("BIG MOUTH: SEASON 4");
        $thirdSerial->setCountry('USA');
        $thirdSerial->setYear(new \DateTime("01-09-2029"));
        $thirdSerial->setCategory($horror);

        $fourthSerial=new Serial();
        $fourthSerial->setName("THE FARE SEASON 5");
        $fourthSerial->setCountry('USA');
        $fourthSerial->setYear(new \DateTime("01-09-2013"));
        $fourthSerial->setCategory($horror);


        $manager->persist($first);
        $manager->persist($second);
        $manager->persist($third);
        $manager->persist($fourth);

        $manager->persist($firstSerial);
        $manager->persist($secondSerial);
        $manager->persist($thirdSerial);
        $manager->persist($fourthSerial);

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
