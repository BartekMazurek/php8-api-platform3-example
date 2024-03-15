<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PromoCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoCodeRepository::class)]
#[ORM\Table(name: "`promo_codes`", schema: "marketing")]
class PromoCode
{
    private const ACTIVE = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(length: 50, unique: true)]
    private string $code;

    #[ORM\Column]
    private int $availableViews;

    #[ORM\Column]
    private int $active;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getAvailableViews(): int
    {
        return $this->availableViews;
    }

    public function setAvailableViews(int $availableViews): void
    {
        $this->availableViews = $availableViews;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function isActive(): bool
    {
        return $this->active === self::ACTIVE;
    }

    public function isAvailableView(): bool
    {
        return $this->availableViews > 0;
    }

    public static function createFromData(
        string $name,
        string $code,
        int $availableViews,
        int $active
    ): PromoCode {

        $entity = new self();
        $entity->name = $name;
        $entity->code = $code;
        $entity->availableViews = $availableViews;
        $entity->active = $active;

        return $entity;
    }
}
