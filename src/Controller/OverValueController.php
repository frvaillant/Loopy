<?php

namespace App\Controller;

use App\Entity\OverValue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OverValueController extends AbstractController
{
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
