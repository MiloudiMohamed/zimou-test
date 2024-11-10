<?php

use App\Data\PackagePriceData;
use App\Support\PackagePriceCalculator;

beforeEach(function () {
    $this->packagePriceCalculator = new PackagePriceCalculator;
});

$priceData = new PackagePriceData(
    price: 3000,
    free_delivery: false,
    delivery_price: 300,
    packaging_price: 100,
    partner_delivery_price: 150,
    partner_cod_price: 300,
    return_price: 100,
    partner_return: 100,
    cod_to_pay: 250,
    extra_weight_price: 200,
    commission: 50
);

it('calculates the total when delivery is not free', function () use ($priceData) {
    expect(
        $this->packagePriceCalculator->total($priceData)
    )->toEqual(4550);
});

it('calculates the total when delivery is free', function () use ($priceData) {
    $priceData->free_delivery = true;

    expect(
        $this->packagePriceCalculator->total($priceData)
    )->toEqual(4000);
});

it('calculates the subtotal when delivery is not free', function () use ($priceData) {
    expect(
        $this->packagePriceCalculator->subtotal($priceData)
    )->toEqual(3750);
});

it('calculates the subtotal when delivery is free', function () use ($priceData) {
    $priceData->free_delivery = true;

    expect(
        $this->packagePriceCalculator->subtotal($priceData)
    )->toEqual(3750);
});
