<?php

namespace App\Controller\Patient;

use App\Entity\Award;
use App\Entity\Badge;
use App\Entity\Data;
use App\Entity\OverValue;
use App\Entity\Patient;
use App\Form\ContactType;
use App\Repository\DataCategoryRepository;
use App\Repository\DataRepository;
use App\Repository\OverValueRepository;
use App\Repository\PatientRepository;
use App\Service\BadgeManager;
use App\Service\MailingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
use Symfony\Component\Validator\Constraints\Json;

class PatientController extends AbstractController
{
    /**
     * @Route("/{id}", name="home")
     * @param $id
     * @param PatientRepository $patientRepository
     * @param SessionInterface $session
     * @return Response
     */
    public function index($id, PatientRepository $patientRepository, SessionInterface $session)
    {
        $patient = $patientRepository->findOneById($id);
        $session->set('patient', $patient);
        return $this->render('patient/index.html.twig', [
                'patient' => $patient
        ]);
    }

    /**
     * @Route("/overvalue/check", name="checkValue")
     */
    public function check()
    {
        $over = $this->getDoctrine()
            ->getRepository(OverValue::class)
            ->findAll();
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
     * @param $glycemy
     * @param PatientRepository $patientRepository
     * @param EntityManagerInterface $em
     * @param DataCategoryRepository $categoryRepository
     * @param OverValueRepository $overValueRepository
     * @param BadgeManager $badgeManager
     * @param SessionInterface $session
     * @return JsonResponse
     */
    public function sendMeasure($glycemy,
                                PatientRepository $patientRepository,
                                EntityManagerInterface $em,
                                DataCategoryRepository $categoryRepository,
                                OverValueRepository $overValueRepository,
                                BadgeManager $badgeManager,
                                SessionInterface $session)
    {
        $responseCode = $patientRepository->saveData($glycemy, $em, $categoryRepository, $overValueRepository);

        $patient = $session->get('patient');

        $data = count($this->getDoctrine()
            ->getRepository(Data::class)
            ->findBy(['patient' => $patient->getId()]));

        $badges = $this->getDoctrine()
            ->getRepository(Badge::class)
            ->findAll();

        $badge = $badgeManager->addBadge($patient, $data, $badges);

        return new JsonResponse([$responseCode, $badge]);
    }

    /**
     * @Route("/parent/{id}", name="parent")
     * @param Patient $patient
     * @param Request $request
     * @return Response
     */
    public function parentTable(Patient $patient, Request $request)
    {
        $form = $this->createForm(ContactType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('patient/parent.html.twig', [
            'patient' => $patient,
            'contact' => $form->createView()
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
