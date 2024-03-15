<?php

declare(strict_types=1);

namespace App\Api\Dto\PromoCode;

use App\Validator\PromoCode\PromoCodeAlreadyExist\PromoCodeAlreadyExist;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Validator\Constraints as Assert;

class PromoCodeCreateInput
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 100)]
    #[Assert\Type(type: Type::BUILTIN_TYPE_STRING)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 50)]
    #[Assert\Type(type: Type::BUILTIN_TYPE_STRING)]
    #[PromoCodeAlreadyExist]
    public string $code;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(value: 0)]
    #[Assert\Type(type: Type::BUILTIN_TYPE_INT)]
    public int $availableViews;

    #[Assert\NotNull]
    #[Assert\Type(type: Type::BUILTIN_TYPE_BOOL)]
    public bool $isActive;
}
