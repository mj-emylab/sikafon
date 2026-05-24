<?php

namespace App\Services;

use Illuminate\Support\Str;

class EcobankPayloadService
{
    private string $affCode = "EGH";

    // private string $sourceIP = "188.214.128.134";
    // private string $sourceIP = "2.24.118.179";        // N
    private string $sourceIP = "36.1.30.36";          // L

    private string $agentCode = "32643218445";

    // private string $pin = "ECOb89b1d4779cb4de#9871785a9f0449c5a";
    private string $pin = "123456";

    private string $channel = "API";

    private string $sourceCode = "EGAL";

    private string $currency = "GHS";

    

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

        // $beforHash = $this->sourceIP .
        //     $requestId .
        //     $this->agentCode .
        //     $currency .
        //     $destination .
        //     $amount .
        //     $this->pin;

        // \Log::info('.....beforHashed....');
        // \Log::info($beforHash);

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

            // "header" => [
            //     "sourceCode" => "OBDX",
            //     "affcode" => "EGH",
            //     "requestId" => "101010101",
            //     "agentcode" => "52728641",
            //     "requestToken" => "51ff7a6de80bff216b918f8e65da926ac7aeadad87a9c40758f18e9b780301ef5b48548f1853a5761aa896af16e70fae2a03d2cbb397437fa2b6fa32f1df9f80",
            //     "requesttype" => "ACCOUNT_OPENING",
            //     "sourceIp" => "10.8.245.9",
            //     "channel" => "API"
            // ],
            // "idNumber" => "GHA-000000000-0",
            // "base64Image" => ""

            'header' => [

                'sourceCode' =>
                    $this->sourceCode,

                'affcode' =>
                    $this->affCode,

                'requestId' =>
                    $requestId,

                'agentcode' =>
                    $this->agentCode,

                'requestToken' =>
                    $this->generateRequestToken(
                        $requestId
                    ),

                'requesttype' =>
                    'ACCOUNT_OPENING',

                'sourceIp' =>
                    $this->sourceIP,

                'channel' =>
                    $this->channel,
            ],

            'idNumber' =>
                $data['idNumber'],

            'base64Image' =>
                $data['base64Image'] ?? '',
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

            'firstname' => $data['firstname'] ?? null,

            'lastname' => $data['lastname'] ?? null,

            'middlename' => $data['middlename'] ?? null,

            'dateOfBirth' =>
                $data['dateOfBirth'] ?? null,

            'identityType' =>
                $data['identityType'] ?? null,

            'identityNo' =>
                $data['identityNo'] ?? null,

            'idIssueDate' =>
                $data['idIssueDate'] ?? null,

            'idExpiryDate' =>
                $data['idExpiryDate'] ?? null,

            'bvn' => $data['bvn'] ?? null,

            'mobileNo' =>
                $data['mobileNo'] ?? null,

            'email' => $data['email'] ?? null,

            'gender' => $data['gender'] ?? null,

            'address' => $data['address'] ?? null,

            'countryCode' =>
                $data['countryCode'] ?? null,

            'transactiontoken' => strtoupper(
                hash(
                    'sha512',
                    $transactionTokenUnhashed
                )
            ),

            'id' => $data['id'] ?? null,
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

        // $transactionTokenUnhashed2 =
        //     $this->sourceIP .'-'.
        //     $requestId .'-'.
        //     $this->agentCode .'-'.
        //     $this->currency .'-'.
        //     $data['senderaccount'] .'-'.
        //     $data['amount'] .'-'.
        //     $this->pin;


        // \Log::info('.....beforHashed....');
        // \Log::info($transactionTokenUnhashed2);

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
}