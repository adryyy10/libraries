<?php

namespace App\Interfaces;

use App\Entity\Usuario;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

interface CRUD 
{
    public function list():array;

    public function create(UserPasswordEncoderInterface $passwordEncoder);

    public function find(int $id): Usuario;

    public function edit(int $id, UserPasswordEncoderInterface $passwordEncoder);

    public function delete(int $id);

    public function persist(Usuario $user);

    public function flush();

}