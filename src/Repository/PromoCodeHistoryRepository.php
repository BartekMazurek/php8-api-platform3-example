<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PromoCodeHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PromoCodeHistoryRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoCodeHistory::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(PromoCodeHistory $promoCodeHistory): void
    {
        $this->entityManager->persist(object: $promoCodeHistory);
        $this->entityManager->flush();
    }
}
