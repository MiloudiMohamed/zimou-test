<?php

namespace App\Support;

use App\Data\PackagePriceData;

class PackagePriceCalculator
{
    public function total(PackagePriceData $form): float
    {
        return $this->subtotal($form) + $this->returnFees($form) + $form->commission;
    }

    public function subtotal(PackagePriceData $form): float
    {
        return $form->price + $form->extra_weight_price
            + $form->partner_cod_price + $form->cod_to_pay
            + $this->deliveryFees($form);
    }

    protected function deliveryFees(PackagePriceData $form): float
    {
        return $form->free_delivery ? 0 : $form->delivery_price + $form->partner_delivery_price + $form->packaging_price;
    }

    protected function returnFees(PackagePriceData $form): float
    {
        return $form->return_price + $form->partner_return;
    }
}
