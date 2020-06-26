<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use App\Repository\RecurrenceRepository;
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
    const MORNING = [
        'start' => '07:00:00',
        'end' => '11:59:59'
    ];

    const NOON = [
        'start' => '12:00:00',
        'end' => '13:59:59'
    ];

    const EVENING = [
        'start' => '14:00:00',
        'end' => '23:59:59'
    ];

    /**
     * @var Security
     */
    private $security;

    /**
     * @var TreatmentRepository
     */
    private $treatment;

    /**
     * @var RecurrenceRepository
     */
    private $recurrence;

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
     * @param RecurrenceRepository $recurrenceRepository
     * @param TotemRepository $tr
     * @param ImagesRepository $imagesRepository
     */
    public function __construct(
        Security $security,
        TreatmentRepository $treatmentRepository,
        RecurrenceRepository $recurrenceRepository,
        TotemRepository $tr,
        ImagesRepository $imagesRepository)
    {
        $this->security = $security;
        $this->treatment = $treatmentRepository;
        $this->recurrence = $recurrenceRepository;
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
        $recurrences = $this->recurrence->findBy(['treatment' => $treatment->getId()]);
        //dd($recurrences);
        $totem = $this->totem->findOneBy(['treatment' => $treatment->getId()]);

        // getting current time
        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/paris'));
        $currentTime = $currentDate->format('H:i:s');

        //
        $message = [];
        $nbDrugs = 0;
        if (self::MORNING['start'] < $currentTime && $currentTime < self::MORNING['end']) {
            foreach ($recurrences as $recurrence) {
                $message = 'Morning';
                if ($recurrence->getMorning() > 0) {
                    $nbDrugs = $nbDrugs + $recurrence->getMorning();
                }
            }
        }
        elseif (self::NOON['start'] < $currentTime && $currentTime < self::NOON['end']) {
            foreach ($recurrences as $recurrence) {
                $message = 'Noon';
                if ($recurrence->getNoon() > 0) {
                    $nbDrugs = $nbDrugs + $recurrence->getNoon();
                }
            }
        }
        elseif (self::EVENING['start'] < $currentTime && $currentTime < self::EVENING['end']) {
            foreach ($recurrences as $recurrence) {
                $message = 'Evening';
                if ($recurrence->getEvening() > 0) {
                    $nbDrugs = $nbDrugs + $recurrence->getEvening();
                }
            }
        }
        else {
            $message = 'Go to sleep';
        }

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
            'currentTime' => $currentTime,
            'message' => $message,
            'nbDrugs' => $nbDrugs,
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
