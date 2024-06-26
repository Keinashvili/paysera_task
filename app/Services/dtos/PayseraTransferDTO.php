<?php

namespace App\Services\dtos;

use Illuminate\Support\Carbon;

readonly class PayseraTransferDTO
{
    public function __construct(
        public array $amount,
        public array $beneficiary,
        public array $payer,
        public array $finalBeneficiary,
        public Carbon $performAt,
        public string $chargeType,
        public string $urgency,
        public array $notifications,
        public array $purpose,
        public array $password,
        public bool $cancelable,
        public bool $autoCurrencyConvert,
        public bool $autoChargeRelatedCard,
        public bool $autoProcessToDone,
        public Carbon $reserveUntil,
        public string $callback,
    ) {
    }
}
