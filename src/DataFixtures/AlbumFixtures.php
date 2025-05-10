<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AlbumFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 30; $i++) {
            $album = new Album();
            $album->setTitle($faker->words(3, true))
                  ->setReleaseDate($faker->dateTimeBetween('-20 years', 'now'))
                  ->setImage($faker->imageUrl(300, 300, 'music', true));

            $manager->persist($album);
        }

        $manager->flush();
    }
}
