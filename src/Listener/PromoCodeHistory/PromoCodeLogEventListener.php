<?php

declare(strict_types=1);

namespace App\Listener\PromoCodeHistory;

use App\Entity\PromoCodeHistory;
use App\Event\PromoCodeHistory\PromoCodeLogEvent;
use App\Repository\PromoCodeHistoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PromoCodeLogEventListener implements EventSubscriberInterface
{
    private PromoCodeHistoryRepository $promoCodeHistoryRepository;

    public function __construct(
        PromoCodeHistoryRepository $promoCodeHistoryRepository
    ) {
        $this->promoCodeHistoryRepository = $promoCodeHistoryRepository;
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
        $this->promoCodeHistoryRepository->save(
            promoCodeHistory: PromoCodeHistory::createFromData(
                operation: $event->getOperation(),
                value: $event->getValue()
            )
        );
    }
}
