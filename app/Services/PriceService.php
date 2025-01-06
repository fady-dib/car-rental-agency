<?php

namespace App\Services\Pricing;

interface PricingStrategy {
    public function calculatePrice(float $base_price, int $days): float;
}

class DefaultPricingStrategy implements PricingStrategy {
    public function calculatePrice(float $base_price, int $days): float {

        $discount = $days > 7 ? 0.1 : 0; 
        return $base_price * $days * (1 - $discount);

    }
}
