<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PromoCodeHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoCodeHistoryRepository::class)]
#[ORM\Table(name: "`promo_codes_history`", schema: "marketing")]
class PromoCodeHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(nullable: true)]
    private ?string $value = null;

    #[ORM\Column(length: 6)]
    private string $operation;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $created;

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    public function getCreated(): \DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): void
    {
        $this->created = $created;
    }

    public static function createFromData(
        string $operation,
        ?string $value
    ): PromoCodeHistory {

        $entity = new self();
        $entity->operation = $operation;
        $entity->value = $value;
        $entity->created = new \DateTimeImmutable();

        return $entity;
    }
}
