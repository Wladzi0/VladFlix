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

        $file1917 = new File();
        $file1917->setAudio(array('en'));
        $file1917->setSubtitle(array('en'));
        $file1917->setPath('example.com///');

        $fileONM = new File();
        $fileONM->setAudio(array('en','pl'));
        $fileONM->setSubtitle(array('en','pl'));
        $fileONM->setPath('ONMexample.com///');

        $fileTS3 = new File();
        $fileTS3->setAudio(array('en'));
        $fileTS3->setSubtitle(array('en','pl'));
        $fileTS3->setPath('TS3example.com///');


        $fileEp1 = new File();
        $fileEp1->setAudio(array('en','cz'));
        $fileEp1->setSubtitle(array('en'));
        $fileEp1->setPath('Ep1example.com///');
        $fileEp2 = new File();
        $fileEp2->setAudio(array('en','cz'));
        $fileEp2->setSubtitle(array('en','cz'));
        $fileEp2->setPath('Ep2example.com///');
        $fileEp3 = new File();
        $fileEp3->setAudio(array('en'));
        $fileEp3->setSubtitle(array('en','cz'));
        $fileEp3->setPath('Ep3example.com///');


        $first = new Film();
        $first->setName("One Night in Miami");
        $first->setCountry('USA');
        $first->setYear(2015);
        $first->setAgeCategory(0);
        $first->setFile($fileONM);
        $first->addCategory($comedy);
        $first->addCategory($horror);
        $first->addCategory($action);

        $second = new Film();
        $second->setName("Toy Story 3");
        $second->setCountry('USA');
        $first->setAgeCategory(null);
        $second->setFile($fileTS3);
        $second->setYear(2017);
        $second->addCategory($comedy);
        $second->addCategory($action);

        $third = new Film();
        $third->setName("1917");
        $third->setAgeCategory(1);
        $third->setCountry('USA');
        $third->setYear(2020);
        $third->setFile($file1917);
        $third->addCategory($horror);
        $third->addCategory($fantasy);

        $firstSerial = new Serial();
        $firstSerial->setName("THE TERROR");
        $firstSerial->setAgeCategory(1);
        $firstSerial->setCountry('USA');
        $firstSerial->setYearStart(2015);
        $firstSerial->addCategory($comedy);

        $seasonTT1 = new Season();
        $seasonTT1->setSerial($firstSerial);
        $seasonTT1->setName("Season 1");
        $seasonTT1->setYear(2015);

        $seasonTT1Ep1 = new Episode();
        $seasonTT1Ep1->setName("Sunrise");
        $seasonTT1Ep1->setYear(2015);
        $seasonTT1Ep1->setFile($fileEp1);
        $seasonTT1Ep1->setSeason($seasonTT1);
        $seasonTT1Ep2 = new Episode();
        $seasonTT1Ep2->setName("Midday");
        $seasonTT1Ep2->setYear(2015);
        $seasonTT1Ep2->setSeason($seasonTT1);
        $seasonTT1Ep2->setFile($fileEp2);
        $seasonTT1Ep3 = new Episode();
        $seasonTT1Ep3->setName("Sunset");
        $seasonTT1Ep3->setYear(2015);
        $seasonTT1Ep3->setSeason($seasonTT1);
        $seasonTT1Ep3->setFile($fileEp3);


        $seasonTT2 = new Season();
        $seasonTT2->setSerial($firstSerial);
        $seasonTT2->setName("Season 2");
        $seasonTT2->setYear(2015);

        $seasonTT3 = new Season();
        $seasonTT3->setSerial($firstSerial);
        $seasonTT3->setName("Season 3");
        $seasonTT3->setYear(2016);


        $secondSerial = new Serial();
        $secondSerial->setName("LUPIN");
        $secondSerial->setAgeCategory(0);
        $secondSerial->setCountry('USA');
        $secondSerial->setYearStart(2018);
        $secondSerial->addCategory($comedy);
        $secondSerial->addCategory($animation);

        $thirdSerial = new Serial();
        $thirdSerial->setName("BIG MOUTH");
        $thirdSerial->setAgeCategory(0);
        $thirdSerial->setCountry('USA');
        $thirdSerial->setYearStart(2029);
        $thirdSerial->addCategory($horror);

        $seasonBM1 = new Season();
        $seasonBM1->setSerial($thirdSerial);
        $seasonBM1->setName("Season 1");
        $seasonBM1->setYear(2029);

        $seasonBM2 = new Season();
        $seasonBM2->setSerial($thirdSerial);
        $seasonBM2->setName("Season 2");
        $seasonBM2->setYear(2029);


        $fourthSerial = new Serial();
        $fourthSerial->setName("THE FARE SEASON 5");
        $fourthSerial->setAgeCategory(null);
        $fourthSerial->setCountry('USA');
        $fourthSerial->setYearStart(2013);
        $fourthSerial->setYearFinish(2016);
        $fourthSerial->addCategory($horror);
        $fourthSerial->addCategory($science);


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

        $manager->persist($file1917);
        $manager->persist($fileONM);
        $manager->persist($fileTS3);
        $manager->persist($fileEp1);
        $manager->persist($fileEp2);
        $manager->persist($fileEp3);


        $manager->persist($first);
        $manager->persist($second);
        $manager->persist($third);

        $manager->persist($firstSerial);
        $manager->persist($secondSerial);
        $manager->persist($thirdSerial);
        $manager->persist($fourthSerial);

        $manager->persist($seasonTT1);
        $manager->persist($seasonTT2);
        $manager->persist($seasonTT3);
        $manager->persist($seasonBM1);
        $manager->persist($seasonBM2);

        $manager->persist($seasonTT1Ep1);
        $manager->persist($seasonTT1Ep2);
        $manager->persist($seasonTT1Ep3);


        $manager->flush();
    }
}
