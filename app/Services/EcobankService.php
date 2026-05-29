<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcobankService
{
    // private string $baseUrl = 'https://xpresspoint.ecobank.com/agencybanking/services/thirdpartyagencybanking';
    private string $baseUrl = 'https://appsqa.ecobank.com/agencybanking/services/thirdpartyagencybanking';

    protected EcobankCryptoService $cryptoService;

    public function __construct(
        EcobankCryptoService $cryptoService
    ) {
        $this->cryptoService = $cryptoService;
    }


    // private string $baseUrl;

    // public function __construct(
    //     EcobankCryptoService $cryptoService
    // ) {
    //     $this->cryptoService = $cryptoService;

    //     $this->baseUrl = config(
    //         'services.ecobank.base_url'
    //     );
    // }




    // DEV TESTING
    public function postTest(
        string $endpoint,
        array $payload
    ): array {

        try {

            Log::info('Ecobank Request', [
                'endpoint' => $endpoint,
                'payload' => $payload,
            ]);

            $response = Http::withoutVerifying()
                ->timeout(120)
                ->acceptJson()
                ->asJson()
                ->withHeaders([
                    'User-Agent' => 'Laravel',
                ])
                ->post(
                    $this->baseUrl . '/' . $endpoint,
                    $payload
                );

            Log::info('Ecobank Response', [
                'status' => $response->status(),
                'body' => $response->body(),
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

    // PRODUCTION SECURE API
    public function post(
        string $endpoint,
        array $payload
    ): array {

        try {

            Log::info('Plain Payload', [
                'payload' => json_encode($payload),
            ]);

            $encrypted =
                $this->cryptoService
                    ->encrypt($payload);

            Log::info('Ecobank Secure Request', [
                'endpoint' => $endpoint,
                'payload' => $payload,
                'encrypted' => $encrypted,
            ]);

            Log::info('Payload Size', [
                'plain_json_bytes' => strlen(json_encode($payload)),
                'encrypted_bytes' => strlen($encrypted),
            ]);

            $response = Http::withOptions([

                // TLS 1.2
                'curl' => [
                    CURLOPT_SSLVERSION =>
                        CURL_SSLVERSION_TLSv1_2,
                ],

                // for QA/testing
                'verify' => false,

                'connect_timeout' => 30,

            ])
            ->asJson()
            ->accept('text/plain')
            ->timeout(120)
            ->post(

                $this->baseUrl .
                '/secure/' .
                $endpoint,

                [
                    'agentcode' => config(
                        'services.ecobank.agent_code'
                    ),

                    'payload' => $encrypted,
                ]
            );

            $rawResponse =
                trim($response->body());

            Log::info('Raw Encrypted Response', [
                'status' => $response->status(),
                'body' => $rawResponse,
            ]);

            if (empty($rawResponse)) {

                throw new \Exception(
                    'Empty response from Ecobank'
                );
            }

            if (!$response->successful()) {

                Log::error('Ecobank HTTP Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'status' => $response->status(),
                    'message' => 'Ecobank request failed',
                    'raw' => $response->body(),
                ];
            }

            if (!base64_decode($rawResponse, true)) {

                Log::error('Invalid encrypted response', [
                    'body' => $rawResponse,
                ]);

                return [
                    'success' => false,
                    'message' => 'Invalid encrypted response',
                    'raw' => $rawResponse,
                ];
            }

            $decrypted =
                $this->cryptoService
                    ->decrypt($rawResponse);

            Log::info('Decrypted Response', [
                'response' => $decrypted,
            ]);

            return [

                'success' =>
                    $response->successful(),

                'status' =>
                    $response->status(),

                'response' =>
                    $decrypted,

                'raw' =>
                    $rawResponse,
            ];

        } catch (\Throwable $e) {

            Log::error(
                'Ecobank Secure Error',
                [
                    'message' =>
                        $e->getMessage(),
                ]
            );

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


    
}