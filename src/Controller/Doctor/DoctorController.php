<?php

namespace App\Controller\Doctor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DoctorController extends AbstractController
{
    /**
     * @Route("/doctor", name="doctor")
     */
    public function index()
    {
        return $this->render('doctor/index.html.twig', [
            'controller_name' => 'DoctorController',
        ]);
    }
}
