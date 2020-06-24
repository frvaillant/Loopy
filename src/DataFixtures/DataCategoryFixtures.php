<?php

namespace App\DataFixtures;

use App\Entity\DataCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DataCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new DataCategory();
        $category->setTitle('Glycémie');
        $manager->persist($category);
        $this->setReference('category', $category);

        $manager->flush();
    }
}
