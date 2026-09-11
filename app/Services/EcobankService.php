<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcobankService
{
    private string $baseUrl = 'https://xpresspoint.ecobank.com/agencybanking/services/thirdpartyagencybanking';


    public function post(
        string $endpoint,
        array $payload
    ) {

        $encrypted =
            $this->cryptoService
                ->encrypt($payload);

        $response = Http::withOptions([])->post(

            $this->baseUrl .
            '/secure/' .
            $endpoint,

            [
                'agentcode' => config(
                    'services.ecobank.agentcode'
                ),

                'payload' => $encrypted,
            ]
        );

        $decrypted =
            $this->cryptoService
                ->decrypt(
                    $response->body()
                );

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'response' => $decrypted,
            'raw' => $response->body(),
        ];
    }
}




// https://documenter.getpostman.com/view/9576712/SzmcZJ78#abfb262c-95d8-48db-8c50-be434e378941
