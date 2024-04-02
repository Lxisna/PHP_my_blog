<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('DUNE');
        $movie->setReleaseYear(2012);
        $movie->setDescription('Dune is a 2021 American epic science fiction film directed and co-produced by Denis Villeneuve, who co-wrote the screenplay with Jon Spaihts and Eric Roth.');
        $movie->setImagePath('https://www.plansamericains.com/wp-content/uploads/Dune-2021-affiche.jpg');
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle('Kung Fu Panda4');
        $movie2->setReleaseYear(2024);
        $movie2->setImagePath('https://www.cinehorizons.net/sites/default/files/affiches/671046041-kung-fu-panda-4.jpg');
        $movie2->setDescription('Kung Fu Panda 4 is a 2024 American animated martial arts comedy film produced by DreamWorks Animation and distributed by Universal Pictures.');
        $manager->persist($movie2);

        $movie3 = new Movie();
        $movie3->setTitle('Tangled');
        $movie3->setReleaseYear(2010);
        $movie3->setImagePath('https://m.media-amazon.com/images/I/91beIPutSkL._SL1500_.jpg');
        $movie3->setDescription('Tangled is a 2010 American animated musical adventure fantasy comedy film produced by Walt Disney Animation Studios and released by Walt Disney Pictures.');
        $manager->persist($movie3);

        $manager->flush();
    }
}
