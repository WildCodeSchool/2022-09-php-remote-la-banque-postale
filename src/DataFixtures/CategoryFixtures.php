<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    public const CATEGORYLIST = [
        // [
        //     'label' => 'Mes favoris',
        //     'image' => 'category1.svg',
        // ],
        [
            'label' => 'Utiliser Ligne Bleue',
            'image' => 'category1.svg',
        ],
        [
            'label' => 'Utiliser mon téléphone',
            'image' => 'category2.svg'
        ],
        [
            'label' => 'Aller sur Internet',
            'image' => 'category3.svg'
        ],
        [
            'label' => 'Vie Courante',
            'image' => 'category4.svg'
        ],
        [
            'label' => 'Me divertir',
            'image' => 'category5.svg'
        ],
        [
            'label' =>  'Mes mails',
            'image' => 'category6.svg'
        ],
        [
            'label' => 'Communiquer',
            'image' => 'category7.svg'
        ],
        [
            'label' =>  'Utiliser Internet en toute sécurité',
            'image' => 'category8.svg'
        ],
        [
            'label' => 'Se déplacer',
            'image' => 'category9.svg'
        ],
        [
            'label' => 'Pour aller plus loin',
            'image' => 'category10.svg'
        ],
        // [
        //     'label' => 'Rechercher un tutoriel',
        //     'image' => 'category10.svg'
        // ],
    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static int $categoryIndex = 0;
    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORYLIST as $key => $categoryInfo) {
            $category = new Category();
            $category->setLabel($categoryInfo['label']);
            $category->setImage($categoryInfo['image']);
            $category->setSlug($this->slugger->slug($category->getLabel()));
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
            self::$categoryIndex++;
        }

        $manager->flush();
    }
}
