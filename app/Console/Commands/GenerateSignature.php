<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSignature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:signature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $payload = json_encode([
            "email" => "fady.dib55@gmail.com",
            "password" => "P@ssword",
        ]);

        $timestamp = time();
        $secret_key = config('services.signature.key');

        $signature = hash_hmac('sha256', $payload . $timestamp, $secret_key);

        $this->info('Client Payload: ' . $payload);
        $this->info('Client Timestamp: ' . $timestamp);
        $this->info('Client Signature: ' . $signature);


    }
}
