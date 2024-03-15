<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\PromoCodeRepository;
use App\Service\PromoCode\PromoCodeReadService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PromoCodeReadDataProvider implements ProviderInterface
{
    private PromoCodeRepository $promoCodeRepository;
    private PromoCodeReadService $promoCodeReadService;

    public function __construct(
        PromoCodeRepository $promoCodeRepository,
        PromoCodeReadService $promoCodeReadService
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
        $this->promoCodeReadService = $promoCodeReadService;
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

        if (empty($promoCode) || !$promoCode->isActive() || !$promoCode->isAvailableView()) {
            throw new NotFoundHttpException(message: 'Promo code not available');
        }

        return $this->promoCodeReadService->getPromoCode(promoCode: $promoCode);
    }
}
