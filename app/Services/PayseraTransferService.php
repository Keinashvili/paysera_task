<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\dtos\PayseraTransferDTO;
use Paysera\Client\TransfersClient\ClientFactory;

class PayseraTransferService
{
    public function initialiseTransaction(PayseraTransferDTO $dto): void
    {
        $clientFactory = new ClientFactory([
            'base_url' => 'https://wallet.paysera.com/transfer/rest/v1/',
            'mac' => [
                'mac_id' => 'mac_id',
                'mac_secret' => 'mac_password',
            ],
        ]);

        $transfersClient = $clientFactory->getTransfersClient();

        $transferInput = (new EntitiesTransferInput())
            ->setAmount($dto->amount)
            ->setBeneficiary($dto->beneficiary)
            ->setPayer($dto->payer)
            ->setFinalBeneficiary($dto->finalBeneficiary)
            ->setPerformAt($dto->performAt)
            ->setChargeType($dto->chargeType)
            ->setUrgency($dto->urgency)
            ->setNotifications($dto->notifications)
            ->setPurpose($dto->purpose)
            ->setPassword($dto->password)
            ->setCancelable($dto->cancelable)
            ->setAutoCurrencyConvert($dto->autoCurrencyConvert)
            ->setAutoChargeRelatedCard($dto->autoChargeRelatedCard)
            ->setAutoProcessToDone($dto->autoProcessToDone)
            ->setReserveUntil($dto->reserveUntil)
            ->setCallback($dto->callback)
        ;

        $result = $transfersClient->createTransfer($transferInput);

        // $result..
    }
}
