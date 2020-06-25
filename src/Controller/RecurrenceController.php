<?php

namespace App\Controller;

use App\Entity\Recurrence;
use App\Entity\Treatment;
use App\Entity\User;
use App\Form\RecurrenceType;
use App\Repository\RecurrenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("user/{user}/treatment/{treatment}/recurrence")
 */
class RecurrenceController extends AbstractController
{
    /**
     * @Route("/", name="recurrence_index", methods={"GET"})
     * @param RecurrenceRepository $recurrenceRepository
     * @return Response
     */
    public function index(RecurrenceRepository $recurrenceRepository): Response
    {
        return $this->render('recurrence/index.html.twig', [
            'recurrences' => $recurrenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="recurrence_new", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param Treatment $treatment
     * @return Response
     */
    public function new(Request $request, User $user, Treatment $treatment): Response
    {
        $recurrence = new Recurrence();
        $form = $this->createForm(RecurrenceType::class, $recurrence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$recurrence->setEnd();
            $entityManager->persist($recurrence);
            $entityManager->flush();

            return $this->redirectToRoute('recurrence_new', ['user'=>$user->getId(), 'treatment'=>$treatment->getId()]);
        }

        return $this->render('recurrence/new.html.twig', [
            'recurrence' => $recurrence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recurrence_show", methods={"GET"})
     * @param Recurrence $recurrence
     * @return Response
     */
    public function show(Recurrence $recurrence): Response
    {
        return $this->render('recurrence/show.html.twig', [
            'recurrence' => $recurrence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recurrence_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recurrence $recurrence): Response
    {
        $form = $this->createForm(RecurrenceType::class, $recurrence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recurrence_index');
        }

        return $this->render('recurrence/edit.html.twig', [
            'recurrence' => $recurrence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recurrence_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Recurrence $recurrence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recurrence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recurrence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recurrence_index');
    }
}
