<?php

namespace App\Controller\Patient;

use App\Entity\OverValue;
use App\Service\MailingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param MailingService $mailingService
     * @return Response
     */
    public function index(MailingService $mailingService)
    {
        return $this->render('patient/index.html.twig', [

        ]);
    }

    /**
     * @Route("/check", name="checkValue")
     */
    public function check()
    {
        $over = $this->getDoctrine()->getRepository(OverValue::class)->findAll();
        $result = [];
        foreach ($over as $key => $value) {
            $id = $value->getPatient()->getId();
            if (!in_array($id, $result)) {
                $result[] = $id;
            }
        }
        return new JsonResponse($result);
    }
}
