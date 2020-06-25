<?php

namespace App\Controller\Doctor;

use App\Entity\Patient;
use App\Form\PatientLimitType;
use App\Form\PatientType;
use App\Repository\DoctorRepository;
use App\Repository\PatientRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DataRepository;
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
     * @param Request $request
     * @param PatientRepository $patientRepository
     * @param DoctorRepository $doctorRepository
     * @return Response
     */
    public function index(Request $request, PatientRepository $patientRepository, DoctorRepository $doctorRepository)

    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->setDoctor($doctorRepository->findOneBy(['id' => 1]));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            $this->addFlash('success', $patient->getFirstName() . ' a bien été ajouté ');

            return $this->redirectToRoute('doctor');
        }
        return $this->render('doctor/index.html.twig', [
            'patients' => $patientRepository->findAll(),
            'form' => $form->createView(),
            'doctor' => $doctorRepository->findOneBy(['surname' => 'Olib']),
        ]);
    }

    /**
     * @Route("/doctor/patient/{id}", name="doctor_patient", methods={"GET", "POST"})
     * @param Patient $patient
     * @param Request $request
     * @param PatientRepository $patientRepository
     * @return Response
     */
    public function showAndEditPatient(Patient $patient, Request $request, PatientRepository $patientRepository)
    {
        $form = $this->createForm(PatientLimitType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Les données de ' . $patient->getFirstName() . ' ont été mises à jour');

            return $this->redirectToRoute('doctor_patient', ['id' => $patient->getId()]);
        }

        return $this->render('doctor/patient/show.html.twig', [
            'choosenPatient' => $patient,
            'patients' => $patientRepository->findAll(),
            'form' => $form->createView()]);
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

        $threshold['min'] = $patient->getLimitDown();
        $threshold['max'] = $patient->getLimitUp();

        return new JsonResponse([
            'lastSurvey' => $lastSurvey,
            'penultimateSurvey' => $penultimateSurvey,
            'threshold' => $threshold
        ]);
    }
}
