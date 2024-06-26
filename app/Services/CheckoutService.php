<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\CheckoutRequest;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\User;
use App\Services\dtos\PayseraTransferDTO;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

readonly class CheckoutService
{
    public function __construct(
        private PayseraTransferService $payseraTransferService
    ) {
    }

    public function process(CheckoutRequest $request): void
    {
        DB::beginTransaction();

        try {
            $this->createOrder($request->user());

            $this->payseraTransferService->initialiseTransaction(
                new PayseraTransferDTO(
                    amount: [],
                    beneficiary: [],
                    payer: [],
                    finalBeneficiary: [],
                    performAt: Carbon::now(),
                    chargeType: 'type',
                    urgency: 'urgency',
                    notifications: [],
                    purpose: [],
                    password: [],
                    cancelable: true,
                    autoCurrencyConvert: true,
                    autoChargeRelatedCard: true,
                    autoProcessToDone: true,
                    reserveUntil: Carbon::now(),
                    callback: 'callback',
                )
            );

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    private function createOrder(User $user): void
    {
        $products = $user->cart->products()->withPivot('quantity')->get();

        $order = new Order();
        $order->user_id = $user->getKey();
        $order->total = $products->sum('price');
        $order->save();

        $productsToInsert = [];

        foreach($products as $product) {
            $newProductToInsert = [];
            $newProductToInsert['order_id'] = $order->getKey();
            $newProductToInsert['product_id'] = $product->getKey();
            $newProductToInsert['quantity'] = $product->pivot->quantity;

            $productsToInsert = $newProductToInsert;
        }

        ProductOrder::query()->insert($productsToInsert);
        CartProduct::query()->where('cart_id', '=', $user->cart->getKey())->delete();
    }
}
