<?php


namespace App\Controller\Patient;


use App\Entity\Badge;
use App\Entity\Data;
use App\Service\BadgeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BadgeController extends AbstractController
{
    /**
     * @Route("/check/badge", name="check_badge")
     * @param BadgeManager $badgeManager
     * @param SessionInterface $session
     * @return JsonResponse
     */
    public function checkBadge(BadgeManager $badgeManager, SessionInterface $session): JsonResponse
    {
        $patient = $session->get('patient');

        $data = count($this->getDoctrine()
            ->getRepository(Data::class)
            ->findBy(['patient' => $patient->getId()]));

        $badges = $this->getDoctrine()
            ->getRepository(Badge::class)
            ->findAll();

        $badge = $badgeManager->addBadge($patient, $data, $badges);

        return new JsonResponse($badge);
    }
}
