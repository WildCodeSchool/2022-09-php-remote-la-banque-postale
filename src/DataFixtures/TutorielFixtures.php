<?php

namespace App\DataFixtures;

use App\Entity\Tutoriel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;



class TutorielFixtures extends Fixture implements DependentFixtureInterface
{

    public static int $tutorielIndex = 0;
    public function load (ObjectManager $manager)
{
    $faker = Factory::create();
    // for ($j = 0; $j < CategoryFixtures::$categoryIndex; $j++) {
    for($i = 0; $i < 152; $i++) {
        $tutoriel = new Tutoriel();
        $tutoriel->setTitle('Fiche' . $faker->title());
        $tutoriel->setDescription($faker->paragraphs(1, true));
        $tutoriel->setLevel($this->getReference('level_' . $faker->numberBetween(0, LevelFixtures::$levelIndex - 1)));
        // $tutoriel->setCategory($this->getReference('category_' . $j));
        $manager->persist($tutoriel);
        $this->addReference('tutoriel_' . self::$tutorielIndex, $tutoriel);
        self::$tutorielIndex++;
    }
    // }

    $manager->flush();

}

public function getDependencies(): array
{
    return [
    //    CategoryFixtures::class,
       LevelFixtures::class,
    ];
}

}
