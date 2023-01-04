<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public static int $userIndex = 0;

    public const USER_INFOS = [
        [
            'firstname' => 'Florian',
            'lastname' => 'Betin',
            'email' => 'florian@laposte.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_ADMIN'
        ],
        [
            'firstname' => 'Hugo',
            'lastname' => 'David',
            'email' => 'david@laposte.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_ADMIN'
        ],
        [
            'firstname' => 'Magali',
            'lastname' => 'Corsale',
            'email' => 'magali@laposte.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_ADMIN'
        ],
        [
            'firstname' => 'Marine',
            'lastname' => 'Valorge',
            'email' => 'marine@laposte.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_ADMIN'
        ],
        [
            'firstname' => 'Ginette',
            'lastname' => 'Lebon',
            'email' => 'Ginette@laposte.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_USER'
        ],
        [
            'firstname' => 'Michel',
            'lastname' => 'Jacquesfils',
            'email' => 'Michel@laposte.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_USER'
        ],
        [
            'firstname' => 'Jihef',
            'lastname' => 'Morin',
            'email' => 'jfmorin@lafriterie.com',
            'pass' => 'mdp',
            'roles' => 'ROLE_USER'
        ],
    ];


    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USER_INFOS as $userInfo) {
            self::$userIndex++;
            $user = new User();
            $user->setEmail($userInfo['email']);
            $user->setFirstname($userInfo['firstname']);
            $user->setLastname($userInfo['lastname']);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userInfo['pass']
            );
            $user->setPassword($hashedPassword);

            $user->setRoles(array($userInfo['roles']));
            $manager->persist($user);
            $this->addReference('user_' . self::$userIndex, $user);
        }
        $manager->flush();
    }
}
