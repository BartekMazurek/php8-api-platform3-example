<?php

declare(strict_types=1);

namespace App\Api\DataProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;

class PromoCodeUpdateDataProcessor implements ProcessorInterface
{
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {
        // TODO - IMPLEMENT LOGIC
    }
}
