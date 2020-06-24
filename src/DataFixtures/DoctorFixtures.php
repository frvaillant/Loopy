<?php

namespace App\DataFixtures;

use App\Entity\Doctor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DoctorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $doctor = new Doctor();
        $doctor->setFirstName('Toto');
        $doctor->setSurname('Olib');
        $manager->persist($doctor);
        $this->setReference('doctor', $doctor);

        $manager->flush();
    }
}
