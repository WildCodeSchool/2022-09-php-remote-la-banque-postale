<?php

namespace App\DataFixtures;

use App\Entity\Page;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class PageFixtures extends Fixture
{
    public const PAGES = [
        [
            'title' => 'Plan du site'
        ],
        [
            'title' => 'Mentions contractuelles'
        ],
        [
        'title' => 'Mentions légales'
        ],
        [
        'title' => 'Données personnelles et cookies'
        ]
    ];
   // public const CONTENT =['']
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
         {
            $page = new Page();
            $page->setContent($faker->paragraphs(10, true));
            $manager->persist($page);
        }

        $manager->flush();
    }
}
