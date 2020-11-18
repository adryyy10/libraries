<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
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
        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $usuarios = $repository->findAll();

        return $this->render('admin/users/list.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * @Route("/new_user", name="form_new_user")
     */
    public function new_user(): Response
    {
        return $this->render('admin/users/new-user.html.twig', [

        ]);
    }

    /**
     * @Route("/add_new_user", name="add_new_user"). methods={"POST"}
     */
    public function add_new_user(UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $usuario = new Usuario;
        $usuario->setNombre($_POST['nombre']);
        $usuario->setUsername($_POST['username']);
        $usuario->setPassword($passwordEncoder->encodePassword($usuario,$_POST['password']));
        $usuario->setRoles(array($_POST['roles']));
        $usuario->setCreatedAt(new \DateTime());
        $usuario->setUpdatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->redirectToRoute('list_users');
    }

    /**
     * @Route("/edit_user/{id}", name="form_update_user")
     */
    public function updateUserForm($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        return $this->render('admin/users/new-user.html.twig', [
            "id" => $id,
            "usuario" => $usuario
        ]);
    }

    /**
     * @Route("update_user/{id}", name="update_user"), methods={"POST"}
     */
    public function updateUser($id, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        $usuario->setNombre($_POST['nombre']);
        $usuario->setUsername($_POST['username']);
        $usuario->setPassword($passwordEncoder->encodePassword($usuario,$_POST['password']));
        $usuario->setRoles(array($_POST['roles']));
        $usuario->setUpdatedAt(new \DateTime());

        $entityManager->flush();

        // redirects to the "list" route
        return $this->redirectToRoute('list_users');
    }

    /**
     * @Route("/adminDashboard/delete/{id}", name="user_delete")
     */
    public function delete($id): Response
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        $entityManager->remove($usuario);
        $entityManager->flush();

        return $this->redirectToRoute('list_users');
    }
}