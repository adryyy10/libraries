<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use App\Entity\Libro;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibroController extends AbstractController
{
    /**
     * @Route("/libro", name="libro")
     */
    public function index(): Response
    {
        return $this->render('admin/libro/index.html.twig', [
            'controller_name' => 'libroController',
        ]);
    }

    /**
     * @Route("/list_libros", name="list_libros")
     */
    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Libro::class);
        $libros = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Biblioteca::class);
        $bibliotecas = $repository->findAll();

        return $this->render('admin/libro/list.html.twig', [
            'libros' => $libros,
            'bibliotecas' => $bibliotecas,
        ]);
    }

    /**
     * @Route("/new_libro", name="form_new_libro")
     */
    public function new_libro(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Biblioteca::class);
        $bibliotecas = $repository->findAll();

        return $this->render('admin/libro/new-libro.html.twig', [
            "bibliotecas" => $bibliotecas
        ]);
    }

    /**
     * @Route("/add_new_libro", name="add_new_libro"). methods={"POST"}
     */
    public function add_new_libro(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($_POST['biblioteca']);
        $libro = new Libro;
        $libro->setTitulo($_POST['titulo']);
        $libro->setBiblioteca($biblioteca);
        $libro->setCreatedAt(new \DateTime());

        $entityManager->persist($libro);
        $entityManager->flush();

        return $this->redirectToRoute('list_libros');
    }

    /**
     * @Route("/edit_libro/{id}", name="form_update_libro")
     */
    public function updatelibroForm($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $libro = $entityManager->getRepository(Libro::class)->find($id);

        $repository = $this->getDoctrine()->getRepository(Biblioteca::class);
        $bibliotecas = $repository->findAll();

        return $this->render('admin/libro/new-libro.html.twig', [
            "id" => $id,
            "libro" => $libro,
            "bibliotecas" => $bibliotecas,
        ]);
    }

    /**
     * @Route("update_libro/{id}", name="update_libro"), methods={"POST"}
     */
    public function updateLibro($id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($_POST['biblioteca']);
        $libro = $entityManager->getRepository(Libro::class)->find($id);

        $libro->setTitulo($_POST['titulo']);
        $libro->setBiblioteca($biblioteca);
        $libro->setUpdatedAt(new \DateTime());

        $entityManager->flush();

        return $this->redirectToRoute('list_libros');
    }

    /**
     * @Route("/libro/delete/{id}", name="libro_delete")
     */
    public function delete($id): Response
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $libro = $entityManager->getRepository(Libro::class)->find($id);

        $entityManager->remove($libro);
        $entityManager->flush();

        return $this->redirectToRoute('list_libros');
    }

}
