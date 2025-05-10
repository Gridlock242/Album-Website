<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 15; $i++) {
            $band = new Band();
            $band->setName($faker->company);
            $band->setBiography($faker->paragraph(3));
            $band->setDateCreated($faker->dateTimeBetween('-30 years', 'now'));
            $band->setImage('https://via.placeholder.com/300x300.png?text=Band+' . ($i + 1));

            $manager->persist($band);
        }

        $manager->flush();
    }
}
