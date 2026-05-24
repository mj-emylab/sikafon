<?php

namespace App\Contracts;

interface IBankingService
{
    public function deposit($agentCode, $ipAddress, $requestID, $transactionToken, $currency, $destinationAccount, $amount, $pin);

    public function withdraw($agentCode, $ipAddress, $requestID, $transactionToken, $currency, $destinationAccount, $amount);

    public function getAccountBalance($agentCode, $ipAddress, $requestID, $accountId);
}
