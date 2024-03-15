<?php

declare(strict_types=1);

namespace App\Service\PromoCode;

use App\Api\Dto\PromoCode\AbstractPromoCodeOutput;
use App\Api\Dto\PromoCode\PromoCodeUpdateInput;
use App\Api\Dto\PromoCode\PromoCodeUpdateOutput;
use App\Entity\PromoCode;
use App\Event\PromoCodeHistory\PromoCodeLogEvent;
use App\Repository\PromoCodeRepository;
use Psr\EventDispatcher\EventDispatcherInterface;

class PromoCodeUpdateService
{
    private PromoCode $promoCode;
    private PromoCodeUpdateInput $input;
    private PromoCodeRepository $promoCodeRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        PromoCodeRepository $promoCodeRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function updatePromoCode(PromoCodeUpdateInput $input): void
    {
        $this->setData(input: $input);
        $this->update();
    }

    private function setData(PromoCodeUpdateInput $input): void
    {
        $this->input = $input;
        $this->promoCode = $this->promoCodeRepository
            ->getPromoCodeBySpecifiedCode(
                code: $this->input->code
            );
    }

    private function update(): void
    {
        $this->promoCode->setName(name: $this->input->name);
        $this->promoCode->setActive(active: (int)$this->input->isActive);

        $this->promoCodeRepository->save(promoCode: $this->promoCode);

        $this->eventDispatcher->dispatch(
            PromoCodeLogEvent::createFromData(
                operation: PromoCodeLogEvent::UPDATE,
                data: [$this->promoCode]
            )
        );
    }

    public function getOutput(): AbstractPromoCodeOutput
    {
        return PromoCodeUpdateOutput::createFromData(
            name: $this->promoCode->getName(),
            code: $this->promoCode->getCode(),
            availableViews: $this->promoCode->getAvailableViews(),
            isActive: (bool)$this->promoCode->getActive()
        );
    }
}
