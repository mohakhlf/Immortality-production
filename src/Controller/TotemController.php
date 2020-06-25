<?php

namespace App\Controller;

use App\Entity\Totem;
use App\Entity\Treatment;
use App\Entity\User;
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

    public function __construct(UserRepository $userRepository, TreatmentRepository $treatmentRepository)
    {
        $this->user = $userRepository;
        $this->treatment = $treatmentRepository;
    }

    /**
     * @Route("/user/{user}/treatment/{treatment}/totem/{id}", name="totem_show")
     * @param Totem $totem
     * @param Treatment $treatment
     * @param User $user
     * @return Response
     */
    public function show(Totem $totem, Treatment $treatment, User $user)
    {
        return $this->render('totem/index.html.twig', [
            'totem' => $totem,
            'treatment' => $treatment,
            'user' => $user,
        ]);
    }
}
