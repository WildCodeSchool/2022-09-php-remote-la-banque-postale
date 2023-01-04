<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Question;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $questionIndex = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($j = 0; $j < TutorielFixtures::$tutorielIndex; $j++) {
            for ($i = 0; $i < 1; $i++) {
                $question = new Question();
                $question->setContent($faker->paragraphs(1, true));
                $question->setTutoriel($this->getReference('tutoriel_' . $j));
                $manager->persist($question);
                $this->addReference('question_' . self::$questionIndex, $question);
                self::$questionIndex++;
            }
        }
            $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           TutorielFixtures::class,
        ];
    }
}
