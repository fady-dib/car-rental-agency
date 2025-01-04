<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\RateLimiterService;


class AuthController extends Controller
{

    protected $rateLimiterService;

    public function __construct(RateLimiterService $rateLimiterService)
    {
        $this->rateLimiterService = $rateLimiterService;
    }

    public function login(Request $request) {

        $key = 'login-' . $request->email;

        if (!$this->rateLimiterService->checkRateLimit($key, 3)) {
            return parent::return_error('Maximum number of attempts reached. Please try again later.', 400, 'Maximum number of attempts reached. Please try again later.');
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).+$/'
            ],
        ]);

        if ($validator->fails()) {
            return parent::return_error(implode(' ', $validator->messages()->all()), 400, 'Invalid credentials');
        }

        $credentials = $request->only('email', 'password');

        if (!$token = auth('user')->attempt($credentials)) {
            return parent::return_error('Invalid credentials' , 401, 'Invalid credentials');
            
        }

        return response()->json([
            'status' => 'success',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
            ]);
    }
}
