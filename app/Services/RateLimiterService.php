<?php

namespace App\Services;

use Illuminate\Support\Facades\RateLimiter;

class RateLimiterService
{
    public function checkRateLimit($key, $maxAttempts = 3)
    {

        $executed =  RateLimiter::attempt(
            $key,
            $maxAttempts,
            function () { },
        );

        return $executed;
    }

}
