<?php

namespace App\Repository;

use App\Entity\Data;
use App\Entity\Patient;
use App\Service\MailingService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    private $mailingService;

    public function __construct(ManagerRegistry $registry, MailingService $mailingService)
    {
        parent::__construct($registry, Patient::class);
        $this->mailingService = $mailingService;
    }

    public function saveData($glycemy, EntityManagerInterface $em, DataCategoryRepository $categoryRepository, OverValueRepository $overValueRepository) {
        $patientId = 22;
        $patient = $this->findOneById($patientId);
        $data = new Data();
        $category = $categoryRepository->findOneBy([]);
        $data->setPatient($patient);
        $data->setValue($glycemy);
        $data->setDataCategory($category);
        $data->setAddedAt(new DateTime());
        $em->persist($data);
        $em->flush();

        $limitUp = $patient->getLimitUp();
        $limitDown = $patient->getLimitDown();
        $state = 'ok';
        if ($glycemy<$limitDown) {
            $state = 'less';
            $overValueRepository->registerOverValue($patient, $em);
            $this->mailingService->emailAlert($patient, 'down');
        }
        if ($glycemy>$limitUp) {
            $state = 'toomuch';
            $overValueRepository->registerOverValue($patient, $em);
            $this->mailingService->emailAlert($patient);
        }
        return ['response' => 201, 'state' => $state];
    }

    // /**
    //  * @return Patient[] Returns an array of Patient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Patient
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
