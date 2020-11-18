<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Entity\Libro;
use App\Entity\Prestamo;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PrestamoController extends AbstractController
{
    /**
     * @Route("/new_prestamo", name="new_prestamo")
     */
    public function new_prestamo(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Biblioteca::class);
        $bibliotecas = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Libro::class);
        $libros = $repository->findAll();

        return $this->render('librarian/prestamo/new-prestamo.html.twig', [
            "bibliotecas" => $bibliotecas,
            "libros" => $libros,
        ]);
    }

    /**
     * @Route("/add_new_prestamo", name="add_new_prestamo"). methods={"POST"}
     */
    public function add_new_prestamo(UserInterface $user): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $libro = $entityManager->getRepository(Libro::class)->find($_POST['libro']);

        $entityManager = $this->getDoctrine()->getManager();
        $usuario = $entityManager->getRepository(Usuario::class)->find($this->get('security.token_storage')->getToken()->getUser());

        $prestamo = new Prestamo;
        $prestamo->setNombre($_POST['nombre']);
        $prestamo->setEmail($_POST['email']);
        $prestamo->setLibro($libro);
        $prestamo->setIdioma($_POST['language']);
        $prestamo->setCreatedBy($usuario);
        $prestamo->setCreatedAt(new \DateTime());

        $entityManager->persist($prestamo);
        $entityManager->flush();

        return $this->redirectToRoute('list_prestamos');
    }



    /**
     * @Route("/prestamos", name="prestamos")
     */
    public function prestamos(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Prestamo::class);
        $prestamos = $repository->findAll();

        return $this->render('librarian/prestamo/list.html.twig', [
            'prestamos' => $prestamos,
        ]);
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
