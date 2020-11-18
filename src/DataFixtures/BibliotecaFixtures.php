<?php

namespace App\DataFixtures;

use App\Entity\Biblioteca;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BibliotecaFixtures extends Fixture
{
    public const BIBLIOTECA_REFERENCE = 'biblioteca-';

    public function load(ObjectManager $manager)
    {
        $biblioteca = new Biblioteca();
        $biblioteca->setNombre('Biblioteca Can Fabra');
        $biblioteca->setCreatedAt(new \DateTime());
        $manager->persist($biblioteca);

        $biblioteca2 = new Biblioteca();
        $biblioteca2->setNombre('Biblioteca La Sagrera-Marina Clotet');
        $biblioteca2->setCreatedAt(new \DateTime());
        $manager->persist($biblioteca2);


        $manager->flush();
    }
}
