<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ticket;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TicketFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $ticketIndex = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($j = 0; $j < UserFixtures::$userIndex; $j++) {
            for ($i = 0; $i < 2; $i++) {
                $ticket = new Ticket();
                $ticket->setTitle('Ticket ' . $faker->title());
                $ticket->setContent($faker->paragraphs(2, true));
                $ticket->setSubmitedAt(DateTimeImmutable::createFromMutable($faker->dateTime()));
                $ticket->setUser($this->getReference('user_' . rand(1, 7)));
                $manager->persist($ticket);
                self::$ticketIndex++;
            }
        }
            $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
           UserFixtures::class,
        ];
    }
}
