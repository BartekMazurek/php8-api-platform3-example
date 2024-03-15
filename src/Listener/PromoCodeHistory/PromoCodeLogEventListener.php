<?php

declare(strict_types=1);

namespace App\Listener\PromoCodeHistory;

use App\Entity\PromoCodeHistory;
use App\Event\PromoCodeHistory\PromoCodeLogEvent;
use App\Repository\PromoCodeHistoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PromoCodeLogEventListener implements EventSubscriberInterface
{
    private PromoCodeHistoryRepository $promoCodeHistoryRepository;
    private SerializerInterface $serializer;

    public function __construct(
        PromoCodeHistoryRepository $promoCodeHistoryRepository,
        SerializerInterface $serializer
    ) {
        $this->promoCodeHistoryRepository = $promoCodeHistoryRepository;
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PromoCodeLogEvent::class => [
                ['logPromoCodeHistory'],
            ],
        ];
    }

    public function logPromoCodeHistory(PromoCodeLogEvent $event): void
    {
        $log = [
            'data' => $event->getData(),
            'operation' => $event->getOperation(),
            'created' => new \DateTimeImmutable(),
        ];

        $this->promoCodeHistoryRepository->save(
            promoCodeHistory: PromoCodeHistory::createFromData(
                value: $this->serializer->serialize(
                    data: $log,
                    format: PromoCodeLogEvent::JSON
                )
            )
        );
    }
}
