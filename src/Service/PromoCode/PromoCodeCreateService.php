<?php

declare(strict_types=1);

namespace App\Service\PromoCode;

use App\Api\Dto\PromoCode\PromoCodeCreateInput;
use App\Api\Dto\PromoCode\PromoCodeCreateOutput;
use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;

class PromoCodeCreateService
{
    private PromoCodeCreateInput $input;
    private PromoCodeRepository $promoCodeRepository;

    public function __construct(
        PromoCodeRepository $promoCodeRepository
    ) {
        $this->promoCodeRepository = $promoCodeRepository;
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

        $this->promoCodeRepository->save($promoCode);
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
