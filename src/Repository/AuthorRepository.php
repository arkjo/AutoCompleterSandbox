<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findLike(string $name): ?array
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.name LIKE :name')
            ->setParameter('name', "%$name%")
            ->orderBy('a.name')
            ->setMaxResults(10)
            ->getQuery()
            ->execute()
        ;
    }

    public function add(Author $author, bool $flush = true): void
    {
        $this->getEntityManager()->persist($author);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
