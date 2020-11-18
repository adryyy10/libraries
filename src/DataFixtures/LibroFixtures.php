<?php

namespace App\DataFixtures;

use App\Entity\Biblioteca;
use App\Entity\Libro;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LibroFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $biblioteca = new Biblioteca();
        $biblioteca->setNombre('Biblioteca Can Fabra');
        $biblioteca->setCreatedAt(new \DateTime());
        $manager->persist($biblioteca);

        $libro = new Libro();
        $libro->setTitulo('La sombra del viento');
        $libro->setBiblioteca($biblioteca);
        $libro->setCreatedAt(new \DateTime());
        $manager->persist($libro);

        $libro2 = new Libro();
        $libro2->setTitulo('El pozo de la eternidad');
        $libro2->setBiblioteca($biblioteca);
        $libro2->setCreatedAt(new \DateTime());
        $manager->persist($libro2);

        $libro3 = new Libro();
        $libro3->setTitulo('Correr o morir');
        $libro3->setBiblioteca($biblioteca);
        $libro3->setCreatedAt(new \DateTime());
        $manager->persist($libro3);


        $manager->flush();
    }
}
