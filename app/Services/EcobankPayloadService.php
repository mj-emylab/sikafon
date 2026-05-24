<?php

namespace App\Services;

use Illuminate\Support\Str;

class EcobankPayloadService
{
    private string $affCode;
    private string $sourceIP;
    private string $agentCode;
    private string $pin;
    private string $channel;
    private string $sourceCode;
    private string $currency;

    public function __construct()
    {
        $this->affCode = config('services.ecobank.aff_code');
        $this->sourceIP = config('services.ecobank.source_ip');
        $this->agentCode = config('services.ecobank.agent_code');
        $this->pin = config('services.ecobank.pin');
        $this->sourceCode = config('services.ecobank.source_code');
        $this->channel = config('services.ecobank.channel');
        $this->currency = config('services.ecobank.currency');
    }
    

    private function generateRequestId(): string
    {
        return (string) random_int(
            100000000,
            999999999
        );
    }


    private function generateRequestToken(string $requestId): string {
        return hash(
            'sha512',
            $this->affCode .
            $requestId .
            $this->agentCode .
            $this->sourceCode .
            $this->sourceIP
        );
    }

    private function generateTransactionToken( string $requestId, string $currency = '', string $destination = '', string $amount = '' ): string {

        return hash(
            'sha512',
            $this->sourceIP .
            $requestId .
            $this->agentCode .
            $currency .
            $destination .
            $amount .
            $this->pin
        );
    }



    public function buildValidateIdentityPayload(
        array $data
    ): array {

        $requestId =
            $this->generateRequestId();

        return [

            'header' => [

                'sourceCode' => $this->sourceCode,

                'affcode' => $this->affCode,

                'requestId' => $requestId,

                'agentcode' => $this->agentCode,

                'requestToken' =>
                    $this->generateRequestToken(
                        $requestId
                    ),

                'requesttype' => 'ACCOUNT_OPENING',
                // 'requesttype' => 'VERIFICATION', // both works

                'sourceIp' => $this->sourceIP,

                'channel' => $this->channel,
            ],

            'idNumber' => $data['idNumber'],

            'base64Image' =>  $data['base64Image'],
        ];
    }



    /*
    |--------------------------------------------------------------------------
    | Create Account Payload
    |--------------------------------------------------------------------------
    */

    public function buildCreateAccountPayload(
        array $data
    ): array {

        $requestId = (string) random_int(
            100000000,
            999999999
        );

        $requestTokenUnhashed =
            $this->affCode .
            $requestId .
            $this->agentCode .
            $this->sourceCode .
            $this->sourceIP;

        $transactionTokenUnhashed =
            $this->sourceIP .
            $requestId .
            $this->agentCode .
            $this->pin;

        return [

            'header' => [
                'affcode' => $this->affCode,
                'sourceIp' => $this->sourceIP,
                'agentcode' => $this->agentCode,
                'channel' => $this->channel,
                'sourceCode' => $this->sourceCode,
                'requestId' => $requestId,
                'requesttype' => 'ACCOUNT_OPENING',

                'requestToken' => strtoupper(
                    hash(
                        'sha512',
                        $requestTokenUnhashed
                    )
                ),
            ],

            'firstname' => strtoupper($data['firstname']),

            'lastname' => strtoupper($data['lastname']),

            'middlename' =>
                !empty($data['middlename'])
                    ? strtoupper($data['middlename'])
                    : '',

            'dateOfBirth' =>
                $data['dateOfBirth'],

            'identityType' =>
                $data['identityType'],

            'identityNo' =>
                strtoupper($data['identityNo']),

            'idIssueDate' =>
                $data['idIssueDate'],

            'idExpiryDate' =>
                $data['idExpiryDate'],

            'mobileNo' =>
                $data['mobileNo'],

            'email' =>
                strtolower($data['email']),

            'gender' =>
                strtoupper($data['gender']),

            'address' =>
                strtoupper($data['address']),

            'countryCode' =>
                strtoupper($data['countryCode']),

            'transactionGuid' => '',

            'transactiontoken' => strtoupper(
                hash(
                    'sha512',
                    $transactionTokenUnhashed
                )
            ),

            'id' => $data['id'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Get Account Payload
    |--------------------------------------------------------------------------
    */

    public function buildGetAccountPayload(
        string $accountRefNo
    ): array {

        $requestId = (string) random_int(
            100000000,
            999999999
        );

        $requestTokenUnhashed =
            $this->affCode .
            $requestId .
            $this->agentCode .
            $this->sourceCode .
            $this->sourceIP;

        $transactionTokenUnhashed =
            $this->sourceIP .
            $requestId .
            $this->agentCode .
            $this->pin;

        return [

            'header' => [

                'affcode' => $this->affCode,

                'sourceIp' => $this->sourceIP,

                'agentcode' => $this->agentCode,

                'channel' => $this->channel,

                'sourceCode' => $this->sourceCode,

                'requestId' => $requestId,

                'requesttype' => 'VALIDATE',

                'requestToken' => strtoupper(
                    hash(
                        'sha512',
                        $requestTokenUnhashed
                    )
                ),
            ],

            'transactiontoken' => strtoupper(
                hash(
                    'sha512',
                    $transactionTokenUnhashed
                )
            ),

            // 'accountRefNo' => $accountRefNo,
            'accountno' => $accountRefNo, 
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Transaction Payload
    |--------------------------------------------------------------------------
    */

    public function buildTransactionPayload(
        array $data
    ): array {

        $requestId = (string) random_int(
            100000000,
            999999999
        );

        $amount = number_format(
            (float) $data['amount'],
            2,
            '.',
            ''
        );

        $requestTokenUnhashed =
            $this->affCode .
            $requestId .
            $this->agentCode .
            $this->sourceCode .
            $this->sourceIP;

        $transactionTokenUnhashed =
            $this->sourceIP .
            $requestId .
            $this->agentCode .
            $this->currency .
            $data['senderaccount'] .
            $amount .
            $this->pin;


        return [

            'header' => [

                'affcode' => $this->affCode,

                'sourceIp' => $this->sourceIP,

                'agentcode' => $this->agentCode,

                'channel' => $this->channel,

                'sourceCode' => $this->sourceCode,

                'requestId' => $requestId,

                'requesttype' =>
                    $data['transactiontype'],

                'requestToken' => strtoupper(
                    hash(
                        'sha512',
                        $requestTokenUnhashed
                    )
                ),
            ],

            'amount' => $amount,

            'senderaccount' =>
                $data['senderaccount'],

            'senderphone' =>
                $data['senderphone'],

            'thirdpartyphonenumber' =>
                $data['thirdpartyphonenumber'],

            'narration' =>
                $data['narration'],

            'subagent' => '',

            'sendername' =>
                $data['sendername'],

            'transactiontype' =>
                $data['transactiontype'],

            'ccy' => $this->currency,

            'transactiontoken' => strtoupper(
                hash(
                    'sha512',
                    $transactionTokenUnhashed
                )
            ),
        ];
    }



    // balance from ecobank

    // get acct number for newly opened from ecobank

    // transactions from ecobank

    // agent transactions from ecobank

    // transaction status from ecobank

    // momo

    // remitance


    
}