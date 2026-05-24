<?php

namespace App\Services;

use App\Jobs\CreateAccountJob;
use Illuminate\Support\Str;

class AccountQueueService
{
    private string $affCode = "EGH";
    private string $sourceIP = "188.214.128.134";
    private string $agentCode = "32643218445";
    private string $pin = "ECOb89b1d4779cb4de#9871785a9f0449c5a";
    private string $channel = 'API';
    private string $sourceCode = "EGAL";
    private string $currency = "GHS";


    public function createAccount(array $payload): void
    {
        $payload['header']['affcode'] = $this->affCode;
        $payload['header']['sourceIp'] = $this->sourceIP;
        $payload['header']['agentcode'] = $this->agentCode;
        $payload['header']['channel'] = $this->channel;
        $payload['header']['sourceCode'] = $this->sourceCode;
        $payload['header']['requestId'] = Str::uuid()->toString();
        $payload['header']['requesttype'] = 'ACCOUNT_OPENING';

        $requestTokenUnhashed =
            $payload['header']['affcode']
            . $payload['header']['requestId']
            . $payload['header']['agentcode']
            . $payload['header']['sourceCode']
            . $payload['header']['sourceIp'];

        $transactionTokenUnhashed =
            $payload['header']['sourceIp']
            . $payload['header']['requestId']
            . $payload['header']['agentcode']
            . $this->pin;

        $payload['header']['requestToken'] =
            hash('sha512', $requestTokenUnhashed);

        $payload['transactiontoken'] =
            hash('sha512', $transactionTokenUnhashed);

        CreateAccountJob::dispatch($payload);
    }
}