<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Answer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $answerIndex = 0;

    public const ANSWERS_SET = [
        [
            'content' => 'vrai',
            'iscorrect' => true,
        ],
        [
            'content' => 'faux',
            'iscorrect' => false,
        ],
        [
            'content' => 'faux',
            'iscorrect' => false,
        ],
        [
            'content' => 'faux',
            'iscorrect' => false,
        ],

    ];


    public function load(ObjectManager $manager): void
    {
        for ($j = 0; $j < QuestionFixtures::$questionIndex; $j++) {
            foreach (self::ANSWERS_SET as $answersSet) {
                $answer = new Answer();
                $answer->setContent($answersSet['content']);
                $answer->setQuestion($this->getReference('question_' . $j));
                $answer->setIscorrect($answersSet['iscorrect']);
                $manager->persist($answer);
                $this->addReference('answer_' . self::$answerIndex, $answer);
                self::$answerIndex++;
            }
        }
            $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           QuestionFixtures::class,
        ];
    }
}
