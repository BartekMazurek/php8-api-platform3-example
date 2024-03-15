<?php

declare(strict_types=1);

namespace App\Validator\PromoCode\PromoCodeExist;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PromoCodeExist extends Constraint
{
    public string $message = 'Promo code does not exist';
}
