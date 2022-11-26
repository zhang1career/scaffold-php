<?php

namespace App\Repository\Impl;

use App\Model\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use http\Exception\RuntimeException;

class UserRepositoryImpl extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry) {
        if ($registry === null) {
            throw new RuntimeException("ManagerRegistry should not be null.");
        }
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false) : int {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $this->getEntityManager()->getConnection()->lastInsertId();
    }

    public function remove(User $entity, bool $flush = false) : void {
        $this->getEntityManager()->remove($entity);
        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $id
     * @return array Returns an array of User objects
     */
    public function findListById($id) : array {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)
            ->orderBy('a.modified_time', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $id
     * @return User|null Returns a User object
     * @throws NonUniqueResultException
     */
    public function findOneById($id) : ?User {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}