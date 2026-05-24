<?php

namespace App\Contracts;

interface ILoggingService
{
    public function logRequest($apiKey, $method, $endpoint, $requestBody, $userId);

    public function logResponse($apiKey, $responseBody, $userId);
}
