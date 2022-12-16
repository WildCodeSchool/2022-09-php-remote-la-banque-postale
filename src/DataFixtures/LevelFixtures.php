<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LevelFixtures extends Fixture
{
    public const LEVELLIST = [
        'Novice',
        'Intermédiaire',
        'Avancé',
    ];

    public static int $levelIndex = 0;
    public function load(ObjectManager $manager): void
    {
        foreach (self::LEVELLIST as $key => $levelName) {
            $level = new Level();
            $level->setName($levelName);
            $manager->persist($level);
            $this->addReference('level_' . $key, $level);
            self::$levelIndex++;
        }

        $manager->flush();
    }
}
