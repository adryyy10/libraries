<?php

namespace App\Controller;

//use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/adminDashboard", name="adminDashboard")
     */
    public function adminDashboard(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(): Response
    {
        //$repository = $this->getDoctrine()->getRepository(Usuario::class);

        return $this->render('admin/list.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
