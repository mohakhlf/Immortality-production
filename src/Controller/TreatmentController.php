<?php

namespace App\Controller;

use App\Entity\Totem;
use App\Entity\Treatment;
use App\Entity\User;
use App\Form\TreatmentType;
use App\Repository\ImagesRepository;
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
     * @param TreatmentRepository $treatmentRepository
     * @return Response
     */
    public function index(TreatmentRepository $treatmentRepository): Response
    {
        return $this->render('treatment/index.html.twig', [
            'treatments' => $treatmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/user/{id}", name="treatment_new", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param ImagesRepository $imagesRepository
     * @return Response
     */
    public function new(Request $request, User $user, ImagesRepository $imagesRepository): Response
    {
        $treatment = new Treatment();
        $treatment->setUser($user);
        $form = $this->createForm(TreatmentType::class, $treatment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Generate a new totem
            $totem = new Totem();
            $image =$imagesRepository->findOneBy(['name' => '10-cat']);
            $totem->setName($treatment->getName());
            $totem->setImage($image);
            $totem->setTreatment($treatment);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($treatment);
            $entityManager->persist($totem);


            $entityManager->flush();

            return $this->redirectToRoute('recurrence_new', ['user'=>$user->getId(), 'treatment'=>$treatment->getId()]);
        }

        return $this->render('treatment/new.html.twig', [
            'treatment' => $treatment,
            'user'=> $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{treatment}/user/{user}", name="treatment_show", methods={"GET"})
     * @param Treatment $treatment
     * @param User $user
     * @return Response
     */
    public function show(Treatment $treatment, User $user): Response
    {
        return $this->render('treatment/show.html.twig', [
            'treatment' => $treatment,
            'user'=> $user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="treatment_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Treatment $treatment
     * @return Response
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
     * @param Request $request
     * @param Treatment $treatment
     * @return Response
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
