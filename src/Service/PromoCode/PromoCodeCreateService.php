<?php

declare(strict_types=1);

namespace App\Service\PromoCode;

use App\Api\Dto\PromoCode\PromoCodeCreateInput;
use App\Api\Dto\PromoCode\PromoCodeCreateOutput;
use App\Entity\PromoCode;
use App\Event\PromoCodeHistory\PromoCodeLogEvent;
use App\Repository\PromoCodeRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PromoCodeCreateService
{
    private PromoCodeCreateInput $input;
    private PromoCodeRepository $promoCodeRepository;
    private EventDispatcherInterface $eventDispatcher;
    private SerializerInterface $serializer;

    public function __construct(
        PromoCodeRepository $promoCodeRepository,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }

    public function createPromoCode(PromoCodeCreateInput $input): void
    {
        $this->setData(input: $input);
        $this->create();
    }

    private function setData(PromoCodeCreateInput $input): void
    {
        $this->input = $input;
    }

    public function create(): void
    {
        $promoCode = PromoCode::createFromData(
            name: $this->input->name,
            code: $this->input->code,
            availableViews: $this->input->availableViews,
            active: (int)$this->input->isActive
        );

        $this->promoCodeRepository->save(promoCode: $promoCode);

        $this->eventDispatcher->dispatch(
            PromoCodeLogEvent::createFromData(
                operation: PromoCodeLogEvent::CREATE,
                value: $this->serializer->serialize(data: $promoCode, format: PromoCodeLogEvent::JSON)
            )
        );
    }

    public function getOutput(): PromoCodeCreateOutput
    {
        return PromoCodeCreateOutput::createFromData(
            name: $this->input->name,
            code: $this->input->code,
            availableViews: $this->input->availableViews,
            isActive: $this->input->isActive
        );
    }
}
