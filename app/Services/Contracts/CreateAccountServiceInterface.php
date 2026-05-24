<?php

namespace App\Services\Contracts;

interface CreateAccountServiceInterface
{
    public function createAccount(array $payload): array|null;
}