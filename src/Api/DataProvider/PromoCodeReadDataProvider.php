<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;

class PromoCodeReadDataProvider implements ProviderInterface
{
    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {
        // TODO - IMPLEMENT LOGIC
    }
}
