<?php

declare(strict_types=1);

namespace App\Api\Dto\PromoCode;

class PromoCodeCreateOutput
{
    public string $name;
    public string $code;
    public int $availableViews;
    public bool $isActive;

    public static function createFromData(
        string $name,
        string $code,
        int $availableViews,
        bool $isActive
    ): PromoCodeCreateOutput {

        $output = new self();
        $output->name = $name;
        $output->code = $code;
        $output->availableViews = $availableViews;
        $output->isActive = $isActive;

        return $output;
    }
}
