<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\Dto\PromoCode\PromoCodeDeleteOutput;
use App\Repository\PromoCodeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PromoCodeDeleteDataProvider implements ProviderInterface
{
    private PromoCodeRepository $promoCodeRepository;

    public function __construct(
        PromoCodeRepository $promoCodeRepository
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {

        if (empty($uriVariables['code'])) {
            throw new NotFoundHttpException(message: 'Missing identifier');
        }

        $promoCode = $this->promoCodeRepository
            ->getPromoCodeBySpecifiedCode(code: $uriVariables['code']);

        if (empty($promoCode)) {
            throw new NotFoundHttpException(message: 'Promo code not available');
        }

        $this->promoCodeRepository->remove(promoCode: $promoCode);

        return new PromoCodeDeleteOutput();
    }
}
