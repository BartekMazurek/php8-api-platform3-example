<?php

declare(strict_types=1);

namespace App\Event\PromoCodeHistory;

use Symfony\Contracts\EventDispatcher\Event;

class PromoCodeLogEvent extends Event
{
    public const JSON = 'json';
    public const CREATE = 'create';
    public const READ = 'read';
    public const UPDATE = 'update';
    public const DELETE = 'delete';

    private string $operation;
    private array $data;

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public static function createFromData(
        string $operation,
        array $data
    ): PromoCodeLogEvent {

        $event = new self();
        $event->operation = $operation;
        $event->data = $data;

        return $event;
    }
}
