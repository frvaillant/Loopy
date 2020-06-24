<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PatientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $day   = rand(1, 29);
        $month = rand(1, 12);
        $year  = rand(2008, 2014);

        for ($i = 0; $i <= 30; $i++) {
            $patient = new Patient();
            $patient->setFirstName($faker->firstName);
            $patient->setSurname($faker->lastName);
            $patient->setBirthday(new DateTime($year . '-' . $month . '-' . $day));
            $patient->setWeight(rand(22, 40));
            $patient->setDoctor($this->getReference('doctor'));
            $patient->setLimitDown(60);
            $patient->setLimitUp(200);
            $manager->persist($patient);
            $this->setReference('patient_' . $i, $patient);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [DoctorFixtures::class];
    }
}
