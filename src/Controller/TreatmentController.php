<?php

namespace App\Controller;

use App\Entity\Treatment;
use App\Form\TreatmentType;
use App\Repository\TreatmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/treatment")
 */
class TreatmentController extends AbstractController
{
    /**
     * @Route("/", name="treatment_index", methods={"GET"})
     */
    public function index(TreatmentRepository $treatmentRepository): Response
    {
        return $this->render('treatment/index.html.twig', [
            'treatments' => $treatmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="treatment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $treatment = new Treatment();
        $form = $this->createForm(TreatmentType::class, $treatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($treatment);
            $entityManager->flush();

            return $this->redirectToRoute('treatment_index');
        }

        return $this->render('treatment/new.html.twig', [
            'treatment' => $treatment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="treatment_show", methods={"GET"})
     */
    public function show(Treatment $treatment): Response
    {
        return $this->render('treatment/show.html.twig', [
            'treatment' => $treatment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="treatment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Treatment $treatment): Response
    {
        $form = $this->createForm(TreatmentType::class, $treatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('treatment_index');
        }

        return $this->render('treatment/edit.html.twig', [
            'treatment' => $treatment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="treatment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Treatment $treatment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$treatment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($treatment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('treatment_index');
    }
}
