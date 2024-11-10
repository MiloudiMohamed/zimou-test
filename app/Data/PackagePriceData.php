<?php

namespace App\Data;

class PackagePriceData
{
    public function __construct(
        public float $price,
        public bool $free_delivery,
        public float $delivery_price,
        public float $packaging_price,
        public float $partner_delivery_price,
        public float $partner_cod_price,
        public float $return_price,
        public float $partner_return,
        public float $cod_to_pay,
        public float $extra_weight_price,
        public float $commission,
    ) {}
}
