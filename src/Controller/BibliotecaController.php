<?php

namespace App\Controller;

use App\Entity\Biblioteca;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliotecaController extends AbstractController
{
    /**
     * @Route("/biblioteca", name="biblioteca")
     */
    public function index(): Response
    {
        return $this->render('biblioteca/index.html.twig', [
            'controller_name' => 'BibliotecaController',
        ]);
    }

    /**
     * @Route("/list_bibliotecas", name="list_bibliotecas")
     */
    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Biblioteca::class);
        $bibliotecas = $repository->findAll();

        return $this->render('admin/biblioteca/list.html.twig', [
            'bibliotecas' => $bibliotecas,
        ]);
    }

    /**
     * @Route("/new_biblioteca", name="form_new_biblioteca")
     */
    public function new_biblioteca(): Response
    {
        return $this->render('admin/biblioteca/new-biblioteca.html.twig', [

        ]);
    }

/**
     * @Route("/add_new_biblioteca", name="add_new_biblioteca"). methods={"POST"}
     */
    public function add_new_biblioteca(): Response
    {
        $biblioteca = new Biblioteca;
        $biblioteca->setNombre($_POST['nombre']);
        $biblioteca->setCreatedAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($biblioteca);
        $entityManager->flush();

        return $this->redirectToRoute('list_bibliotecas');
    }

    /**
     * @Route("/edit_biblioteca/{id}", name="form_update_biblioteca")
     */
    public function updateBibliotecaForm($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($id);

        return $this->render('admin/biblioteca/new-biblioteca.html.twig', [
            "id" => $id,
            "biblioteca" => $biblioteca
        ]);
    }

    /**
     * @Route("update_biblioteca/{id}", name="update_biblioteca"), methods={"POST"}
     */
    public function updateBilioteca($id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($id);

        $biblioteca->setNombre($_POST['nombre']);
        $biblioteca->setUpdatedAt(new \DateTime());

        $entityManager->flush();

        return $this->redirectToRoute('list_bibliotecas');
    }

    /**
     * @Route("/biblioteca/delete/{id}", name="biblioteca_delete")
     */
    public function delete($id): Response
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $biblioteca = $entityManager->getRepository(Biblioteca::class)->find($id);

        $entityManager->remove($biblioteca);
        $entityManager->flush();

        return $this->redirectToRoute('list_bibliotecas');
    }

}
