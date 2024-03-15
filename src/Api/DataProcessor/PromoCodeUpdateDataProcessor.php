<?php

declare(strict_types=1);

namespace App\Api\DataProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Dto\PromoCode\PromoCodeUpdateInput;
use App\Service\PromoCode\PromoCodeUpdateService;

class PromoCodeUpdateDataProcessor implements ProcessorInterface
{
    private PromoCodeUpdateService $promoCodeUpdateService;

    public function __construct(
        PromoCodeUpdateService $promoCodeUpdateService
    ) {
        $this->promoCodeUpdateService = $promoCodeUpdateService;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {
        if (!$data instanceof PromoCodeUpdateInput) {
            throw new \InvalidArgumentException('Wrong input data');
        }

        $this->promoCodeUpdateService->updatePromoCode(input: $data);

        return $this->promoCodeUpdateService->getOutput();
    }
}
