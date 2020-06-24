<?php

namespace App\Controller\Doctor;

use App\Entity\Doctor;
use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\DoctorRepository;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DoctorController extends AbstractController
{
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
            $patient->setDoctor($doctorRepository->findOneBy(['id'=>1]));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('doctor');
        }
        return $this->render('doctor/index.html.twig', [
            'patients'=> $patientRepository->findAll(),
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/doctor/patient/{id}", name="doctor_patient", methods={"GET"})
     * @param Patient $patient
     * @param PatientRepository $patientRepository
     * @return Response
     */
    public function showPatient(Patient $patient, PatientRepository $patientRepository)
    {
        return $this->render('doctor/onepatient.html.twig', [
            'choosenPatient'=> $patient,
            'patients'=> $patientRepository->findAll()
        ]);
    }
}
