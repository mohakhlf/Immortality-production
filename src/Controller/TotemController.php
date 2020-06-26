<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use App\Repository\TotemRepository;
use App\Repository\TreatmentRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @var Security
     */
    private $security;

    /**
     * @var TreatmentRepository
     */
    private $treatment;

    /**
     * @var TotemRepository
     */
    private $totem;

    /**
     * @var ImagesRepository
     */
    private $images;

    /**
     * TotemController constructor.
     * @param Security $security
     * @param TreatmentRepository $treatmentRepository
     * @param TotemRepository $tr
     * @param ImagesRepository $imagesRepository
     */
    public function __construct(
        Security $security,
        TreatmentRepository $treatmentRepository,
        TotemRepository $tr,
        ImagesRepository $imagesRepository)
    {
        $this->security = $security;
        $this->treatment = $treatmentRepository;
        $this->totem = $tr;
        $this->images = $imagesRepository;
    }

    /**
     * @Route("/totem/", name="totem_show")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function show(EntityManagerInterface $em): Response
    {
        // fetch user, treatment, totem and totem image
        $user = $this->security->getUser();
        $treatment = $this->treatment->findOneBy(['user' => $user->getId()]);
        $totem = $this->totem->findOneBy(['treatment' => $treatment->getId()]);

        $dateNow = new \DateTime('now');
        dd($dateNow);

        // get scores to compare
        $totemScore = $totem->getScore();
        $imageScore = $totem->getImage()->getScore();

        if ($totemScore >= 1 && $totemScore <= 20) {
            if ($totemScore > $imageScore) {
                // find the next image
                $newImage = $this->images->find($totem->getImage()->getId() + 1);
                // update totem image
                $totem->setImage($newImage);

                // update database
                $em->flush();
            }
            elseif ($totemScore < $imageScore) {
                // find the previous image
                $newImage = $this->images->find($totem->getImage()->getId() - 1);
                // update totem image
                $totem->setImage($newImage);

                // update database
                $em->flush();
            }
        }

        return $this->render('totem/index.html.twig', [
            'totem' => $totem,
        ]);
    }

    /**
     * @Route("/totem/up", name="totem_up")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function up(EntityManagerInterface $em): Response
    {
        // get the totem
        $user = $this->security->getUser();
        $treatment = $this->treatment->findOneBy(['user' => $user->getId()]);
        $totem = $this->totem->findOneBy(['treatment' => $treatment->getId()]);

        // increase totem score by one
        $totem->setScore($totem->getScore() + 1);
        // increase user score by one
        $user->setScore($user->getScore() + 1);

        // update database
        $em->flush();

        return $this->redirectToRoute('totem_show');
    }

    /**
     * @Route("/totem/down", name="totem_down")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function down(EntityManagerInterface $em): Response
    {
        // get the totem
        $user = $this->security->getUser();
        $treatment = $this->treatment->findOneBy(['user' => $user->getId()]);
        $totem = $this->totem->findOneBy(['treatment' => $treatment->getId()]);

        // decrease totem score by one
        $totem->setScore($totem->getScore() - 1);

        // update database
        $em->flush();

        return $this->redirectToRoute('totem_show');
    }
}
