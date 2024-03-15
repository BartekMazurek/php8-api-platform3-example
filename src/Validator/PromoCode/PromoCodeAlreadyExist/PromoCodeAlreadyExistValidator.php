<?php

declare(strict_types=1);

namespace App\Validator\PromoCode\PromoCodeAlreadyExist;

use App\Repository\PromoCodeRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PromoCodeAlreadyExistValidator extends ConstraintValidator
{
    private PromoCodeRepository $promoCodeRepository;

    public function __construct(
        PromoCodeRepository $promoCodeRepository
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
    }

    public function validate(
        mixed $value,
        Constraint $constraint
    ): void {

        if (empty($value) || !is_string($value)) {
            return;
        }

        $promoCode = $this->promoCodeRepository->getPromoCodeBySpecifiedCode(code: $value);

        if (!$promoCode) {
            return;
        }

        /** @var PromoCodeAlreadyExist $constraint */
        $this->context->buildViolation($constraint->message)->addViolation();
    }
}
