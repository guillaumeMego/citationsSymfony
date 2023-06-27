<?php

namespace App\Repository;

use App\Entity\Auteurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auteurs>
 *
 * @method Auteurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auteurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auteurs[]    findAll()
 * @method Auteurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auteurs::class);
    }

    public function save(Auteurs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Auteurs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
