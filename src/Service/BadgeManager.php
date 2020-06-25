<?php


namespace App\Service;


use App\Entity\Award;
use App\Entity\Badge;
use App\Entity\Data;
use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;

class BadgeManager
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addBadge(Patient $patient, int $data, array $badges)
    {
        switch ($data) {
            case 1:
                $award = new Award();
                $award->setPatient($patient);
                $award->setBadge($badges[0]);
                $this->em->persist($award);
                break;
            case 4:
                $award = new Award();
                $award->setPatient($patient);
                $award->setBadge($badges[1]);
                $this->em->persist($award);
                break;
            case 24:
                $award = new Award();
                $award->setPatient($patient);
                $award->setBadge($badges[2]);
                $this->em->persist($award);
                break;
            case 96:
                $award = new Award();
                $award->setPatient($patient);
                $award->setBadge($badges[4]);
                $this->em->persist($award);
                break;
            case 576:
                $award = new Award();
                $award->setPatient($patient);
                $award->setBadge($badges[6]);
                $this->em->persist($award);
                break;
            case 1152:
                $award = new Award();
                $award->setPatient($patient);
                $award->setBadge($badges[7]);
                $this->em->persist($award);
                break;
            default:
                $award = null;
        }
        $this->em->flush();
        $response = [];
        if (!is_null($award)) {
            $response = [
                'patientId' => $patient->getId(),
                'badge' => $award->getBadge()->getId()
            ];
        }
        return $response;
    }
}
