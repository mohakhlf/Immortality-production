<?php


namespace App\Controller;

use App\Entity\Totem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     * @return Response
     */
    public function index() :Response
    {
        return $this->render('home/index.html.twig', [
            'title' => 'Welcome to the Nameless Project !',
        ]);
    }
}
