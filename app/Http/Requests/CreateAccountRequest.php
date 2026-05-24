<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'nullable|string',
            'lastname' => 'nullable|string',
            'middlename' => 'nullable|string',
            'dateOfBirth' => 'nullable|string',
            'identityType' => 'nullable|string',
            'identityNo' => 'nullable|string',
            'idIssueDate' => 'nullable|string',
            'idExpiryDate' => 'nullable|string',
            'bvn' => 'nullable|string',
            'mobileNo' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'countryCode' => 'nullable|string',
            'transactiontoken' => 'nullable|string',
            'id' => 'required|string',
            'header' => 'required|array',
        ];
    }
}