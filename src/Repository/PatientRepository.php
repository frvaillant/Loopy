<?php

namespace App\Repository;

use App\Entity\Data;
use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use \DateTime;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    public function saveData($glycemy, EntityManagerInterface $em, DataCategoryRepository $categoryRepository) {
        $patientId = 22;
        $patient = $this->findOneById($patientId);
        $data = new Data();
        $category = $categoryRepository->findOneById(1);
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
        }
        if ($glycemy>$limitUp) {
            $state = 'toomuch';
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
