<?php

namespace App\Controller\Doctor;

use App\Entity\Patient;
use App\Repository\DataRepository;
use App\Repository\DoctorRepository;
use App\Repository\PatientRepository;
use App\Service\DataManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DoctorController extends AbstractController
{
    const NUMBER_OF_DATA = 28; // 7jours

    /**
     * @Route("/doctor", name="doctor")
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function index(DoctorRepository $doctorRepository): Response
    {
        return $this->render('doctor/index.html.twig', [
            'doctor' => $doctorRepository->findOneBy(['surname' => 'Olib']),
        ]);
    }

    /**
     * @Route("/doctor/fetchData/{id}", name="fetch_data")
     * @param Patient $patient
     * @param DataRepository $dataRepository
     * @param DataManager $dataManager
     * @return JsonResponse
     */
    public function fetchData(Patient $patient, DataRepository $dataRepository, DataManager $dataManager): JsonResponse
    {
        $lastSurvey = $dataRepository->findBy(['patient' => $patient], ['addedAt' => 'DESC'], self::NUMBER_OF_DATA);
        $lastSurvey = $dataManager->prepareDataForGraphic($lastSurvey);

        $penultimateSurvey = $dataRepository->findBy(['patient' => $patient], ['addedAt' => 'DESC'], self::NUMBER_OF_DATA, self::NUMBER_OF_DATA);
        $penultimateSurvey = $dataManager->prepareDataForGraphic($penultimateSurvey);

        return new JsonResponse([
            'lastSurvey' => $lastSurvey,
            'penultimateSurvey' => $penultimateSurvey
        ]);
    }
}
