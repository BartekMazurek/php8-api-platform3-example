<?php

declare(strict_types=1);

namespace App\Validator\PromoCode\PromoCodeAlreadyExist;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PromoCodeAlreadyExist extends Constraint
{
    public string $message = 'Promo code with specified code already exist';
}
