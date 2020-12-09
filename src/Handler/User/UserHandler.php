<?php

namespace App\Handler\User;

use App\Entity\Usuario;
use App\Interfaces\CRUD;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandler implements CRUD
{
    protected $entityManagerInterface;
    protected $usuarioRepository;

    public function __construct(EntityManagerInterface $entityManagerInterface, UsuarioRepository $usuarioRepository)
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->usuarioRepository = $usuarioRepository;
    }

    public function list(): array
    {
        return $this->usuarioRepository->findAll();
    }

    public function create(UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new Usuario;
        $this->handleUser($passwordEncoder, $user);
        $this->persist($user);
        $this->flush();
    }

    public function find(int $id): Usuario
    {
        return $this->usuarioRepository->find($id);
    }

    public function edit(int $id, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->find($id);
        $this->handleUser($passwordEncoder, $user);
        $this->persist($user);
        $this->flush();
    }

    public function delete(int $id)
    {
        $user = $this->find($id);
        $this->remove($user);
        $this->flush();
    }

    public function persist(Usuario $user)
    {
        $this->entityManagerInterface->persist($user);
    }

    public function remove(Usuario $user)
    {
        $this->entityManagerInterface->remove($user);
    }

    public function flush()
    {
        $this->entityManagerInterface->flush();
    }

    public function handleUser(UserPasswordEncoderInterface $passwordEncoder, Usuario $user)
    {
        $user->setNombre($_POST['nombre']);
        $user->setUsername($_POST['username']);
        $user->setPassword($passwordEncoder->encodePassword($user,$_POST['password']));
        $user->setRoles(array($_POST['roles']));
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());
    }
}