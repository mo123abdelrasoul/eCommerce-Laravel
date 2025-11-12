<?php

namespace App\Services;

class ShippingAddressService
{
    public function prepare(array $checkoutData): array
    {
        return [
            "city" => $checkoutData['city'] ?? null,
            "street_number" => $checkoutData['street_number'] ?? null,
            "street_name" => $checkoutData['street_name'] ?? null,
            "zip" => $checkoutData['zip_code'] ?? null,
        ];
    }
}
