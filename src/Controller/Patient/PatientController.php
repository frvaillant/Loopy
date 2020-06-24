<?php

namespace App\Controller\Patient;

use App\Entity\Patient;
use App\Service\MailingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MailingService $mailingService)
    {
        return $this->render('patient/index.html.twig', [

        ]);
    }
}
