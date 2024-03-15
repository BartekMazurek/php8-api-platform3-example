<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PromoCodeHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoCodeHistoryRepository::class)]
#[ORM\Table(name: "`promo_codes_history`", schema: "marketing")]
class PromoCodeHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public static function createFromData(
        string $value
    ): PromoCodeHistory {

        $entity = new self();
        $entity->value = $value;

        return $entity;
    }
}
