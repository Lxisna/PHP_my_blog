<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName('Bill Anderson');
        $manager->persist($actor);

        $actor2 = new Actor();
        $actor2->setName('Ken Stott');
        $manager->persist($actor2);

        $actor3 = new Actor();
        $actor3->setName('Ricky Tomlinson');
        $manager->persist($actor3);

        $manager->flush();

    }
}
