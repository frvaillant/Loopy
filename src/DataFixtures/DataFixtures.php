<?php

namespace App\DataFixtures;

use App\Entity\Data;
use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture implements DependentFixtureInterface
{
    const HOURS = [
        7,
        11,
        15,
        19
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 30; $i++) {
            for ($j = 1; $j <= 30; $j++) {
                for ($k = 0; $k < 4; $k++) {
                    $data = new Data();
                    $time = new DateTime('2020-06-' . $j . ' ' . self::HOURS[$k] . ':00:00');
                    $data->setPatient($this->getReference('patient_' . $i));
                    $data->setDataCategory($this->getReference('category'));
                    $data->setValue(rand(80, 120));
                    $data->setAddedAt($time);
                    $manager->persist($data);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PatientFixtures::class,
            DataCategoryFixtures::class
        ];
    }
}
