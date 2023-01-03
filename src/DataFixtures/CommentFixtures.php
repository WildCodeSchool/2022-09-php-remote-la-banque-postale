<?php

namespace App\DataFixtures;

use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $commentIndex = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($j = 0; $j < TutorielFixtures::$tutorielIndex; $j++) {
            for ($i = 0; $i < 5; $i++) {
                $comment = new Comment();
                $comment->setText($faker->paragraphs(2, true));
                $comment->setPostedAt(DateTimeImmutable::createFromMutable($faker->dateTime()));
                $comment->setTutoriel($this->getReference('tutoriel_' . $j));
                $comment->setUser($this->getReference('user_' . rand(1, 7)));
                $manager->persist($comment);
                $this->addReference('comment_' . self::$commentIndex, $comment);
                self::$commentIndex++;
            }
        }
            $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           TutorielFixtures::class,
           UserFixtures::class,
        ];
    }
}
