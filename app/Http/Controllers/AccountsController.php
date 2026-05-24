<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Services\Contracts\CreateAccountServiceInterface;
use Illuminate\Http\JsonResponse;

class AccountsController extends Controller
{
    public function __construct(
        private readonly CreateAccountServiceInterface $createAccountService
    ) {}

    public function createAccount(
        CreateAccountRequest $request
    ): JsonResponse {

        $result = $this->createAccountService
            ->createAccount($request->validated());

        if (!$result) {
            return response()->json([
                'message' => 'Failed to create account'
            ], 400);
        }

        return response()->json($result);
    }
}