<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tutoriel;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TutorielFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static int $tutorielIndex = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($j = 0; $j < CategoryFixtures::$categoryIndex; $j++) {
            for ($i = 0; $i < 13; $i++) {
                $tutoriel = new Tutoriel();
                $tutoriel->setTitle('Fiche ' . $faker->title() . ' ' . $j . $i);
                $tutoriel->setDescription($faker->paragraphs(1, true));
                $tutoriel->setContent($faker->paragraphs(5, true));
                $tutoriel->setSlug($this->slugger->slug($tutoriel->getTitle()));
                $tutoriel->setLevel($this->getReference('level_' .
                    $faker->numberBetween(0, LevelFixtures::$levelIndex - 1)));
                $tutoriel->setCategory($this->getReference('category_' . $j));
                $manager->persist($tutoriel);
                $this->addReference('tutoriel_' . self::$tutorielIndex, $tutoriel);
                self::$tutorielIndex++;
            }
        }

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
