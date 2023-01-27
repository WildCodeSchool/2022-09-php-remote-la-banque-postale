<?php

namespace App\Repository;

use App\Entity\GameAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Question;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<GameAnswer>
 *
 * @method GameAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameAnswer[]    findAll()
 * @method GameAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameAnswer::class);
    }

    public function save(GameAnswer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GameAnswer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCorrectAnswersByUser(User $user, Question $question): array
    {
        return $this->createQueryBuilder('ga')
            ->join('ga.game', 'g')
            ->join('ga.answer', 'a')
            ->where('g.user = :user')
            ->andWhere('ga.question = :question')
            ->setParameters(['user' => $user, 'question' => $question])
            ->andWhere('a.isCorrect = 1')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return GameAnswer[] Returns an array of GameAnswer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GameAnswer
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
