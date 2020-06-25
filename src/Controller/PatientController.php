<?php


namespace App\Controller;


use App\Entity\Treatment;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\TreatmentRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/patient")
 */
class PatientController extends AbstractController
{
    private $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

    /**
     * @Route("/", name="patient_index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
        ]);
    }

    /**
     * @Route("/edit/{id}", name="patient_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $patient
     * @return Response
     */
    public function edit(Request $request, User $patient): Response
    {
        $form = $this->createForm(UserType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }
}
