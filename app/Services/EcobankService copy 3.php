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

        if (!file_exists(storage_path('certs/client.pem'))) {
            throw new \Exception('client.pem missing');
        }

        if (!file_exists(storage_path('certs/client.key'))) {
            throw new \Exception('client.key missing');
        }

        if (!file_exists(storage_path('certs/ecobank-ca.pem'))) {
            throw new \Exception('client.ecobank-ca.pem missing');
        }

        try {

            $encrypted =
                $this->cryptoService
                    ->encrypt($payload);

            $response = Http::withOptions([

                'cert' => storage_path(
                    'certs/client.pem'
                ),

                'ssl_key' => storage_path(
                    'certs/client.key'
                ),

                'verify' => storage_path(
                    'certs/ecobank-ca.pem'
                ),

                'curl' => [
                    CURLOPT_SSLVERSION =>
                        CURL_SSLVERSION_TLSv1_2,
                ],

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

            if (empty($rawResponse)) {

                throw new \Exception(
                    'Empty response from Ecobank'
                );
            }

            Log::info('Raw Encrypted Response', [
                'body' => $rawResponse,
            ]);

            $decrypted =
                $this->cryptoService
                    ->decrypt($rawResponse);

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