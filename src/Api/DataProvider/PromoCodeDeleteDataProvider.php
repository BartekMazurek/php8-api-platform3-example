<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\Dto\PromoCode\PromoCodeDeleteOutput;
use App\Event\PromoCodeHistory\PromoCodeLogEvent;
use App\Repository\PromoCodeRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PromoCodeDeleteDataProvider implements ProviderInterface
{
    private PromoCodeRepository $promoCodeRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        PromoCodeRepository $promoCodeRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
        $this->eventDispatcher = $eventDispatcher;
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

        $promoCodeId = $promoCode->getId();
        $this->promoCodeRepository->remove(promoCode: $promoCode);

        $this->eventDispatcher->dispatch(
            PromoCodeLogEvent::createFromData(
                operation: PromoCodeLogEvent::DELETE,
                data: ['id' => $promoCodeId]
            )
        );

        return new PromoCodeDeleteOutput();
    }
}
