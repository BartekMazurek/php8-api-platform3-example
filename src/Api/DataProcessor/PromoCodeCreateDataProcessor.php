<?php

declare(strict_types=1);

namespace App\Api\DataProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Dto\PromoCode\PromoCodeCreateInput;
use App\Service\PromoCode\PromoCodeCreateService;

class PromoCodeCreateDataProcessor implements ProcessorInterface
{
    private PromoCodeCreateService $promoCodeCreateService;

    public function __construct(
        PromoCodeCreateService $promoCodeCreateService
    ) {
        $this->promoCodeCreateService = $promoCodeCreateService;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        if (!$data instanceof PromoCodeCreateInput) {
            throw new \InvalidArgumentException(message: 'Wrong input data');
        }

        $this->promoCodeCreateService->createPromoCode(input: $data);

        return $this->promoCodeCreateService->getOutput();
    }
}
