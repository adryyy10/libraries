<?php

namespace App\Controller\User;

use App\Entity\Usuario;
use App\Handler\User\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    protected $userHandler;
    public function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;
    }

    /**
     * @Route("/adminDashboard", name="adminDashboard")
     */
    public function adminDashboard(): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/list_users", name="list_users")
     */
    public function list(): Response
    {
        $usuarios = $this->userHandler->list();

        return $this->render('admin/users/list.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * @Route("/new_user", name="form_new_user")
     */
    public function new_user(): Response
    {
        return $this->render('admin/users/new-user.html.twig');
    }

    /**
     * @Route("/add_new_user", name="add_new_user"). methods={"POST"}
     */
    public function add_new_user(UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->userHandler->create($passwordEncoder);
        return $this->redirectToRoute('list_users');
    }

    /**
     * @Route("/edit_user/{id}", name="form_update_user")
     */
    public function updateUserForm($id): Response
    {
        $user = $this->userHandler->find($id);
        return $this->render('admin/users/new-user.html.twig', [
            "id" => $id,
            "usuario" => $user
        ]);
    }

    /**
     * @Route("update_user/{id}", name="update_user"), methods={"POST"}
     */
    public function updateUser(int $id, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->userHandler->edit($id, $passwordEncoder);
        return $this->redirectToRoute('list_users');
    }

    /**
     * @Route("/adminDashboard/delete/{id}", name="user_delete")
     */
    public function delete(int $id): Response
    {
        $this->userHandler->delete($id);
        return $this->redirectToRoute('list_users');
    }
}
