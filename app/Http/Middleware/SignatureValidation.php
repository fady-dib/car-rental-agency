<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Log;

class SignatureValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client_signature = $request->header('X-Signature');
        $timestamp = $request->header('X-Timestamp');
        $secret_key = config('services.signature.key');


        if (!$client_signature || !$timestamp) {
            return $this->return_error('Invalid Request' , 400, 'Invalid Request');
        }

        if (abs(time() - $timestamp) > 300) {
            return $this->return_error('Request Expired' , 400, 'Request Expired');
        }

        $payload = json_encode($request->all());


        $server_signature = hash_hmac('sha256', $payload . $timestamp, $secret_key);
        Log::info('Raw Payload: ' . $payload);
        Log::info('Server Timestamp: ' . $timestamp);
        Log::info('Server Signature: ' . $server_signature);
        Log::info('Client Signature: ' . $client_signature);



        if (!hash_equals($server_signature, $client_signature)) {
            return $this->return_error('Invalid Signature' , 403, 'Invalid Signature');
        }

        return $next($request);

    }

      public function return_error($debugger, $code, $message)
    {
        $error['error'] = [];
        $error['error']['debugger'] = $debugger;
        $error['error']['code'] = $code;
        $error['error']['message'] = $message;

        return response()->json($error)->setStatusCode(400);
    }
}
