<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PromoCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PromoCodeRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoCode::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(PromoCode $promoCode): void
    {
        $this->entityManager->persist(object: $promoCode);
        $this->entityManager->flush();
    }

    public function getPromoCodeBySpecifiedCode(string $code): ?PromoCode
    {
        return $this->createQueryBuilder(alias: 'pc')
            ->andWhere('pc.code = :code')
            ->setParameter(key: 'code', value: $code)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
