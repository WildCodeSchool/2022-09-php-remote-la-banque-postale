<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    public const CATEGORYLIST = [
        'Mes Favoris',
        'Utiliser Ligne Bleue',
        'Utiliser mon téléphone',
        'Aller sur Internet',
        'Vie Courante',
        'Me divertir',
        'Mes mails',
        'Communiquer',
        'Utiliser Internet en toute sécurité',
        'Se déplacer',
        'Pour aller plus loin',
    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static int $categoryIndex = 0;
    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORYLIST as $key => $categoryLabel) {
            $category = new Category();
            $category->setLabel($categoryLabel);
            $category->setSlug($this->slugger->slug($category->getLabel()));
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
            self::$categoryIndex++;
        }

        $manager->flush();
    }
}