<?php

namespace App\DataFixtures;

use App\Entity\Data;
use App\Entity\OverValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DataFixtures extends Fixture implements DependentFixtureInterface
{
    const BEFORE_EAT = [
        7,
        11,
        19
    ];

    const AFTER_EAT = [
        10,
        14,
        21
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 30; $i++) {
            $patient = $manager->find('App:Patient', $this->getReference('patient_' . $i));
            for ($j = 1; $j <= 24; $j++) {
                for ($k = 0; $k < 3; $k++) {
                    $osef[$i][$j][$k] = $this->randomPreprandiale();
                    $data = new Data();
                    $time = new DateTime('2020-06-' . $j . ' ' . self::BEFORE_EAT[$k] . ':00:00');
                    $data->setPatient($patient);
                    $data->setDataCategory($this->getReference('category'));
                    $data->setValue($osef[$i][$j][$k]);
                    if ($data->getValue() < $patient->getLimitDown() || $data->getValue() > $patient->getLimitUp()) {
                        $over = new OverValue();
                        $over->setPatient($data->getPatient());
                        $over->setHasValue(true);
                        $manager->persist($over);
                    }
                    $data->setAddedAt($time);
                    $manager->persist($data);
                }
            }
        }

        for ($i = 0; $i <= 30; $i++) {
            $patient = $manager->find('App:Patient', $this->getReference('patient_' . $i));
            for ($j = 1; $j <= 24; $j++) {
                for ($k = 0; $k < 3; $k++) {
                    $data = new Data();
                    $time = new DateTime('2020-06-' . $j . ' ' . self::AFTER_EAT[$k] . ':00:00');
                    $data->setPatient($patient);
                    $data->setHasEaten(true);
                    $data->setDataCategory($this->getReference('category'));
                    $data->setValue($this->randomPostprandiale($osef[$i][$j][$k]));
                    if ($data->getValue() < $patient->getLimitDown() || $data->getValue() > $patient->getLimitUp()) {
                        $over = new OverValue();
                        $over->setPatient($data->getPatient());
                        $over->setHasValue(true);
                        $manager->persist($over);
                    }
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

    public function randomPreprandiale()
    {
        $bas = rand(40, 70);
        $normal = rand(70, 120);
        $haut = rand(120, 150);
        $random = rand(1, 10);

        $result = $normal;
        if ($random === 1) {
            $result = $bas;
        } elseif ($random === 10) {
            $result = $haut;
        }

        return $result;
    }

    public function randomPostprandiale(int $osef)
    {
        $bas = rand(10, 30);
        $normal = rand(30, 70);
        $haut = rand(70, 120);
        $random = rand(1, 10);

        $result = $osef + $normal;
        if ($random === 1) {
            $result = $osef + $bas;
        } elseif ($random === 10) {
            $result = $osef + $haut;
        }

        return $result;
    }
}

