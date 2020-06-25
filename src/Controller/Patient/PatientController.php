<?php

namespace App\Controller\Patient;

use App\Entity\Data;
use App\Entity\OverValue;
use App\Entity\Patient;
use App\Repository\DataCategoryRepository;
use App\Repository\DataRepository;
use App\Repository\OverValueRepository;
use App\Repository\PatientRepository;
use App\Service\MailingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
use Symfony\Component\Validator\Constraints\Json;

class PatientController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
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

    /**
     * @Route("/patient/measure/{glycemy}", name="send_value", methods={"PUT"})
     */
    public function sendMeasure ($glycemy, PatientRepository $patientRepository,  EntityManagerInterface $em, DataCategoryRepository $categoryRepository, OverValueRepository $overValueRepository)
    {
        // $patient = $this->getUser();
        $responseCode = $patientRepository->saveData($glycemy, $em, $categoryRepository, $overValueRepository);

        return new JsonResponse($responseCode);
    }

    /**
     * @Route("/parent/index/", name="send_value")
     */
    public function parentTable()
    {
        $patient = $this->getDoctrine()->getRepository(Patient::class)->find(94);
        return $this->render('patient/parent.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/patient/overvalue/delete/{id}", name="delete_overvalue")
     * @param $id
     * @param PatientRepository $patientRepository
     * @param OverValueRepository $overValueRepository
     * @return JsonResponse
     */
    public function deleteOverValue($id, PatientRepository $patientRepository, OverValueRepository $overValueRepository): JsonResponse
    {
        $patient = $patientRepository->find($id);
        $overValue = $overValueRepository->findBy(['patient' => $patient]);
        foreach ($overValue as $value) {
            $this->getDoctrine()->getManager()->remove($value);
        }
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }
}
