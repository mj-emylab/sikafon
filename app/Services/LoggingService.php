<?php

namespace App\Services;

use App\Contracts\ILoggingService;
use App\Models\Log;

class LoggingService implements ILoggingService
{
    public function logRequest($apiKey, $method, $endpoint, $requestBody, $userId)
    {
        $log = new Log();
        $log->api_key = $apiKey;
        $log->method = $method;
        $log->endpoint = $endpoint;
        $log->request_body = $requestBody;
        $log->user_id = $userId;
        $log->save();
    }

    public function logResponse($apiKey, $responseBody, $userId)
    {
        $log = new Log();
        $log->api_key = $apiKey;
        $log->response_body = $responseBody;
        $log->user_id = $userId;
        $log->save();
    }
}
