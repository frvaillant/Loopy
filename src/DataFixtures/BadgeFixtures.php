<?php

namespace App\DataFixtures;

use App\Entity\Badge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BadgeFixtures extends Fixture
{
    const TITLES = [
        'Premier relevé',
        'Premier jour',
        '1 semaine',
        '1 semaine équilibrée',
        '1 mois',
        '1 mois équilibré',
        '6 mois',
        '1 an',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::TITLES as $key => $value) {
            $badge = new Badge();
            $badge->setTitle($value);
            $badge->setImage('https://images-na.ssl-images-amazon.com/images/I/71CAzupglSL._AC_UX679_.jpg');
            $manager->persist($badge);
            $this->setReference('badge_' . $key, $badge);
        }

        $manager->flush();
    }
}
