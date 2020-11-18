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
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function add_new_prestamo(\Swift_Mailer $mailer, TranslatorInterface $translator): Response
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

        //IDIOMA MENSAJE
        $translated = 'Llibre reservat correctament';
        if($_POST['language'] == 'Español'){
            $translated = $translator->trans('Llibre reservat correctament');
        }
        $mensaje = $translated . ": " . $prestamo->getLibro()->getTitulo();

        //ENVÍO DE EMAIL
        $message = (new \Swift_Message("Mensaje enviado"))
        ->setFrom('pruebatecnicatd@gmail.com')
        ->setTo($_POST['email'])
        ->setBody(
            $this->renderView(
                'emails/prestamo.html.twig',
                [
                    'nombre' => $_POST['nombre'], 
                    'mensaje' => $mensaje 
                ],
                
            ),
            'text/html'
        );
        $mailer->send($message);

        return $this->render('emails/prestamo.html.twig', [
            "mensaje" => $mensaje,
        ]);
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
     * @Route("/prestamo/cancelar/{id}", name="prestamo_cancelar")
     */
    public function cancelar($id): Response
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $prestamo = $entityManager->getRepository(Prestamo::class)->find($id);

        $entityManager->remove($prestamo);
        $entityManager->flush();

        return $this->redirectToRoute('prestamos');
    }
}
