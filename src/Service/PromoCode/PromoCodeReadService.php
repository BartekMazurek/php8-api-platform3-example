<?php

declare(strict_types=1);

namespace App\Service\PromoCode;

use App\Api\Dto\PromoCode\AbstractPromoCodeOutput;
use App\Api\Dto\PromoCode\PromoCodeReadOutput;
use App\Entity\PromoCode;
use App\Event\PromoCodeHistory\PromoCodeLogEvent;
use App\Repository\PromoCodeRepository;
use Psr\EventDispatcher\EventDispatcherInterface;

class PromoCodeReadService
{
    private PromoCode $promoCode;
    private PromoCodeRepository $promoCodeRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        PromoCodeRepository $promoCodeRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getPromoCode(PromoCode $promoCode): AbstractPromoCodeOutput
    {
        $this->setData(promoCode: $promoCode);
        $this->updatePromoCodeCounter();

        return $this->getOutput();
    }

    private function setData(PromoCode $promoCode): void
    {
        $this->promoCode = $promoCode;
    }

    private function updatePromoCodeCounter(): void
    {
        $this->promoCode->setAvailableViews(
            availableViews: $this->promoCode->getAvailableViews() - 1
        );

        $this->promoCodeRepository->save(promoCode: $this->promoCode);

        $this->eventDispatcher->dispatch(
            PromoCodeLogEvent::createFromData(
                operation: PromoCodeLogEvent::READ,
                data: [$this->promoCode]
            )
        );
    }

    private function getOutput(): AbstractPromoCodeOutput
    {
        return PromoCodeReadOutput::createFromData(
            name: $this->promoCode->getName(),
            code: $this->promoCode->getCode(),
            availableViews: $this->promoCode->getAvailableViews(),
            isActive: (bool)$this->promoCode->getActive()
        );
    }
}
