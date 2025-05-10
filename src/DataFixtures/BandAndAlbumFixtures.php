<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BandAndAlbumFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Données des groupes
        $bands = [
            ['Tool', 'Tool est un groupe de metal progressif américain formé en 1990.', '1990-01-01', 'tool.jpg'],
            ['Nasty', 'Nasty est un groupe de beatdown hardcore belge, actif depuis 2004.', '2004-01-01', 'nasty.jpg'],
            ['Dir En Grey', 'Dir En Grey est un groupe japonais de metal expérimental formé en 1997.', '1997-01-01', 'direngey.jpg'],
            ['Skinny Puppy', 'Skinny Puppy est un groupe canadien de musique industrielle formé en 1982.', '1982-01-01', 'skinny_puppy.jpg'],
            ['Prodigy', 'The Prodigy est un groupe britannique de musique électronique formé en 1990.', '1990-01-01', 'prodigy.jpg'],
            ['Korn', 'Korn est un groupe de nu metal américain fondé en 1993.', '1993-01-01', 'korn.jpg'],
            ['Static-X', 'Static-X est un groupe américain de metal industriel formé en 1994.', '1994-01-01', 'staticx.jpg'],
            ['Rob Zombie', 'Rob Zombie est un musicien américain connu pour son style industriel et horrifique.', '1997-01-01', 'rob_zombie.jpg'],
            ['Slipknot', 'Slipknot est un groupe américain de metal alternatif formé en 1995.', '1995-01-01', 'slipknot.jpg'],
            ['Aphex Twin', 'Aphex Twin est un artiste britannique de musique électronique et ambient.', '1992-01-01', 'aphex_twin.jpg'],
            ['Machine Girl', 'Machine Girl est un projet américain de breakcore et noise punk.', '2013-01-01', 'machinegirl.jpg'],
            ['Siouxsie and the Banshees', 'Groupe post-punk britannique fondé en 1976.', '1976-01-01', 'siouxsie.jpg'],
            ['Sister Of Mercy', 'The Sisters of Mercy est un groupe de rock gothique britannique fondé en 1980.', '1980-01-01', 'sister_of_mercy.jpg'],
        ];

        $bandObjects = [];
        foreach ($bands as $index => [$name, $biography, $dateCreated, $image]) {
            $band = new Band();
            $band->setName($name);
            $band->setBiography($biography);
            $band->setDateCreated(new \DateTime($dateCreated));
            $band->setImage($image);

            $manager->persist($band);
            $bandObjects[] = $band; 
        }

        $manager->flush(); 

        $albumsData = [
            ['Lateralus', '2001-05-15', 0, 'lateralus.jpg'],
            ['10 000 Days', '2006-05-02', 0, '10k_days.jpg'],
            ['Shokka', '2022-03-18', 1, 'shokka.jpg'],
            ['Menace', '2015-09-25', 1, 'menace.jpg'],
            ['Gauze', '1999-07-28', 2, 'gauze.jpg'],
            ['Dum Spiro Spero', '2011-08-03', 2, 'dum_spiro_spero.jpg'],
            ['Vulgar', '2003-09-10', 2, 'vulgar.jpg'],
            ['Bites', '1985-08-01', 3, 'bites.jpg'],
            ['Rabies', '1989-11-21', 3, 'rabies.jpg'],
            ['Remission', '1984-12-01', 3, 'remission.jpg'],
            ['Fat of the land', '1997-06-30', 4, 'fat_of_the_land.jpg'],
            ['Experience', '1992-09-28', 4, 'experience.jpg'],
            ['Follow the leader', '1998-08-18', 5, 'follow_the_leader.jpg'],
            ['Korn', '1994-10-11', 5, 'korn.jpg'],
            ['Life is Peachy', '1996-10-15', 5, 'life_is_peachy.jpg'],
            ['Wisconsin Death Trip', '1999-03-23', 6, 'wisconsin_death_trip.jpg'],
            ['Shadow Zone', '2003-10-07', 6, 'shadow_zone.jpg'],
            ['Hellbilly Deluxe', '1998-08-25', 7, 'hellbilly_deluxe.jpg'],
            ['Past, Present & Future', '2003-10-07', 7, 'past_present_future.jpg'],
            ['Subliminal Verse', '2004-05-25', 8, 'subliminal_verse.jpg'],
            ['Slipknot', '1999-06-29', 8, 'slipknot.jpg'],
            ['Iowa', '2001-08-28', 8, 'iowa.jpg'],
            ['WindowLicker', '1999-03-22', 9, 'windowlicker.jpg'],
            ['Come To Daddy', '1997-10-06', 9, 'come_to_daddy.jpg'],
            ['On', '1993-11-15', 9, 'on.jpg'],
            ['Selected Ambient Works', '1992-02-12', 9, 'selected_ambient_works.jpg'],
            ['wlfgrl', '2014-04-01', 10, 'wlfgrl.jpg'],
            ['Juju', '1981-06-06', 11, 'juju.jpg'],
            ['Tinderbox', '1986-04-21', 11, 'tinderbox.jpg'],
            ['Floodland', '1987-11-13', 12, 'floodland.jpg'],
        ];

        foreach ($albumsData as [$title, $releaseDate, $bandIndex, $image]) {
            $album = new Album();
            $album->setTitle($title);
            $album->setReleaseDate(new \DateTime($releaseDate));
            $album->setImage($image);

            // Se souvenir que c'est avec cette ligne qu'on associe les groupes avec leur album
            $album->setBand($bandObjects[$bandIndex]);

            $manager->persist($album);
        }

        $manager->flush(); 
    }
}
