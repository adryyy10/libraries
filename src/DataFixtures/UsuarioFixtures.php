<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $usuario = new Usuario();
        $usuario->setNombre('Adria');
        $usuario->setUsername('Adryyy10');
        $usuario->setPassword($this->passwordEncoder->encodePassword(
            $usuario,
            '1234'
        ));
        $usuario->setRoles(array('ROLE_ADMIN'));
        $usuario->setCreatedAt(new \DateTime());
        $usuario->setUpdatedAt(new \DateTime());
        $manager->persist($usuario);

        $usuario2 = new Usuario();
        $usuario2->setNombre('AdriaLibrarian');
        $usuario2->setUsername('AdryyyLibrarian');
        $usuario2->setPassword($this->passwordEncoder->encodePassword(
            $usuario2,
            '1234'
        ));
        $usuario2->setRoles(array('ROLE_LIBRARIAN'));
        $usuario2->setCreatedAt(new \DateTime());
        $usuario2->setUpdatedAt(new \DateTime());
        $manager->persist($usuario2);


        $manager->flush();
    }
}
