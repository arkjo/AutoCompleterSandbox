<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findAll(): ?array
    {
        return $this
            ->createQueryBuilder('b')
            ->orderBy('b.title')
            ->getQuery()
            ->execute()
        ;
    }

    public function add(Book $book, bool $flush = true): void
    {
        $this->getEntityManager()->persist($book);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
