<?php

namespace App\Controller\Doctor;

use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DoctorController extends AbstractController
{
    /**
     * @Route("/doctor", name="doctor")
     * @param PatientRepository $patientRepository
     * @return Response
     */
    public function index(PatientRepository $patientRepository)
    {
        return $this->render('doctor/index.html.twig', [
            'patients'=> $patientRepository->findAll()
        ]);
    }
}
