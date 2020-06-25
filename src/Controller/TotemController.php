<?php

namespace App\Controller;

use App\Entity\Totem;
use App\Entity\Treatment;
use App\Entity\User;
use App\Repository\TotemRepository;
use App\Repository\TreatmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TotemController
 * @package App\Controller
 */
class TotemController extends AbstractController
{
    private $user;

    private $treatment;

    private $totem;

    public function __construct(UserRepository $userRepository, TreatmentRepository $treatmentRepository, TotemRepository $totemRepository)
    {
        $this->user = $userRepository;
        $this->treatment = $treatmentRepository;
        $this->totem = $totemRepository;
    }

    /**
     * @Route("/user/{user}/totem/", name="totem_show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->render('totem/index.html.twig', [
        ]);
    }
}
