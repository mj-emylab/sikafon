<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcobankService
{
    // private string $baseUrl = 'https://xpresspoint.ecobank.com/agencybanking/services/thirdpartyagencybanking/';
    // private string $baseUrl = 'https://mule.ecobank.com/agencybanking/services/thirdpartyagencybanking/';
    private string $baseUrl = 'https://devtuat.ecobank.com/agencybanking/services/thirdpartyagencybanking/';

    
    public function post(
        string $endpoint,
        array $payload
    ): array {

        try {

            Log::info('Ecobank Request', [
                'endpoint' => $endpoint,
                'payload' => $payload,
            ]);

            $jsonPayload = json_encode(
                $payload,
                JSON_UNESCAPED_SLASHES
            );

            // $response = Http::withoutVerifying()
            //     ->timeout(120)
            //     ->withHeaders([
            //         'Accept' => 'application/json',
            //         'User-Agent' => 'PostmanRuntime/7.32.3',
            //     ])
            //     ->post(
            //         $this->baseUrl . $endpoint,
            //         $payload
            //     );

            $response = Http::withoutVerifying()
                ->timeout(120)
                ->acceptJson()
                ->asJson()
                ->withHeaders([
                    'User-Agent' => 'Laravel',
                ])
                ->post(
                    $this->baseUrl . $endpoint,
                    $payload
                );

            Log::info('Ecobank Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            Log::info('Ecobank Response Headers', [
                'headers' => $response->headers(),
            ]);

            return [

                'success' =>
                    $response->successful(),

                'status' =>
                    $response->status(),

                'response' =>
                    $response->json(),

                'raw' =>
                    $response->body(),
            ];

        } catch (\Throwable $e) {

            Log::error('Ecobank Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}