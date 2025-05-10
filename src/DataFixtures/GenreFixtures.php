<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 10; $i++) {
            $genre = new Genre();
            $genre->setName($faker->words(3, true));

            $manager->persist($genre);
        }

        $manager->flush();
    }
}