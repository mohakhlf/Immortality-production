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
use Symfony\Component\Security\Core\Security;

/**
 * Class TotemController
 * @package App\Controller
 */
class TotemController extends AbstractController
{
    /**
     * @var
     */
    private $security;

    /**
     * @var
     */
    private $treatment;

    /**
     * @var
     */
    private $totem;

    /**
     * TotemController constructor.
     * @param Security $security
     * @param TreatmentRepository $treatmentRepository
     * @param TotemRepository $tr
     */
    public function __construct(Security $security, TreatmentRepository $treatmentRepository, TotemRepository $tr)
    {
        $this->security = $security;
        $this->treatment = $treatmentRepository;
        $this->totem = $tr;
    }

    /**
     * @Route("/totem/", name="totem_show")
     * @return Response
     */
    public function show(): Response
    {
        $user = $this->security->getUser();
        $treatment = $this->treatment->findOneBy(['user' => $user->getId()]);
        $totem = $this->totem->findOneBy(['treatment' => $treatment->getId()]);
        //dd($totem->getImage());

        return $this->render('totem/index.html.twig', [
            'totem' => $totem,
        ]);
    }
}
