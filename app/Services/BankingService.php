<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\RequestLog;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\AccountUser;
use App\Models\Account;
use App\Models\User;

use Carbon\Carbon;

use App\Helper\Helpers;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Jobs\DynamicMailJob;

class BankingService {

    // protected $baseUrl = "https://appsqa.ecobank.com/";
    // protected $baseUrl = "https://xpresspoint.ecobank.com/";  // main
    protected $baseUrl = "https://devtuat.ecobank.com/";   // dev

    protected $client;
    protected $logger;

    protected $pin = "ECOb89b1d4779cb4de#9871785a9f0449c5a";
    protected $sourceCode = "EGAL";
    protected $affcode = "EGH";
    protected $agentcode = "32643218445";
    protected $sourceIp = "188.214.128.134";

    // protected $channel = "API";
    protected $channel = "MOBILE";

    protected $currency = "GHS";

    public function __construct(Client $client, LoggerInterface $logger) {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function deposit($sendername, $subagentcode, $senderphone, $senderaccount, $thirdpartyphonenumber, $narration, $amount, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/cashin';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        // $sendername = "TestEugene TestMiddleNAme TestLastName";
        // $subagentcode = "90808987";
        // $senderphone = "23324412345678";
        // $senderaccount = "233501374526";
        // $thirdpartyphonenumber = "";
        // $narration = "TESTING CASH";
        // $amount = "20.0";

        $sendername = $sendername;
        $subagentcode = $subagentcode;
        $senderphone = $senderphone;
        $senderaccount = $senderaccount;
        $thirdpartyphonenumber = $thirdpartyphonenumber;
        $narration = $narration;
        $amount = $amount;

        $requesttype = 'CASH_IN';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);

        // var transactionTokenUnhashed = sourceIp + requestId + agentcode + currency + senderaccount + amount + pin ;
        $inputString = $sourceIp . $requestId . $agentCode . $ccy . $senderaccount . $amount . $pin;
        $transactionToken =  hash('sha512', $inputString);

        $payload = [
            'sendername' => $sendername,
            'senderphone' => $senderphone,
            'senderaccount' => $senderaccount,
            'thirdpartyphonenumber' => $thirdpartyphonenumber,
            'narration' => $thirdpartyphonenumber,
            'ccy' => $ccy,
            'amount' => $amount,
            // 'subagent' => $subagentcode,
            "subagentcode" => $subagentcode,

            // 'transactiontoken' => $transactionToken,
            'transactiontoken' => "7b926624059513827cb9368246c632deeda816c541c2eb9a0a78dcbf1bdafcb36e862be84420b645cbdf688806539f914175a044dcb762f44530314ab22a4e63",

            'header' => [
                'affcode' => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                'sourceCode' => $sourceCode,
                'sourceIp' => $sourceIp,
                'channel' => $channel,
                'requesttype' => $requesttype,
                'agentcode' => $agentCode,
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }

    public function createAccount($firstname, $lastname, $middlename, $dateOfBirth, $identityType, $identityNo, $idIssueDate, $idExpiryDate, $bvn, $mobileNo, $email, $gender, $address, $countryCode, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/createaccount';

        \Log::info('Generated Request Token2: ' . $logable_type. 'here');

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        $firstname = $firstname;
        $lastname = $lastname;
        $middlename = $middlename;
        $dateOfBirth = $dateOfBirth; // "yyyy-MM-dd"
        $identityType = $identityType;
        $identityNo = $identityNo;
        $idIssueDate = $idIssueDate;
        $idExpiryDate = $idExpiryDate;
        $bvn = $bvn;
        $mobileNo = $mobileNo;
        $email = $email;
        $gender = $gender;
        $address = $address;
        $countryCode = $countryCode;

        $requesttype = 'ACCOUNT_OPENING';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);
        
        // var transactionTokenUnhashed = sourceIp + requestId + agentcode + pin;
        $inputString = $sourceIp . $requestId . $agentCode . '' . '' . '' . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $senderaccount . $amount . $pin;
        $transactionToken =  hash('sha512', $inputString);

        $payload = [
            "firstname" => $firstname,
            "lastname" => $lastname,
            "middlename" => $middlename,
            "dateOfBirth" => $dateOfBirth,
            "identityType" => $identityType,
            "identityNo" => $identityNo,
            "idIssueDate" => $idIssueDate,
            "idExpiryDate" => $idExpiryDate,
            "mobileNo" => $mobileNo,
            "email" => $email,
            "gender" => $gender,
            "address" => $address,
            "countryCode" => $countryCode,

            // "transactiontoken" => $transactionToken,
            "transactiontoken" => "7b926624059513827cb9368246c632deeda816c541c2eb9a0a78dcbf1bdafcb36e862be84420b645cbdf688806539f914175a044dcb762f44530314ab22a4e63",

            "header" => [
                "affcode" => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                "sourceCode" => $sourceCode,
                "sourceIp" => $sourceIp,
                "channel" => $channel,
                "requesttype" => $requesttype,
                "agentcode" => $agentCode
            ],
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }



    public function withdrawal($sendername, $subagentcode, $senderphone, $senderaccount, $thirdpartyphonenumber, $narration, $amount, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/withdrawal';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        // $sendername = "TestEugene TestMiddleNAme TestLastName";
        // $subagentcode = "90808987";
        // $senderphone = "23324412345678";
        // // $senderphone = "233501374526";
        // $senderaccount = "233501374526";
        // $thirdpartyphonenumber = "";
        // $narration = "TESTING CASH";
        // $amount = "20.0";

        $sendername = $sendername;
        $subagentcode = $subagentcode;
        $senderphone = $senderphone;
        $senderaccount = $senderaccount;
        $thirdpartyphonenumber = $thirdpartyphonenumber;
        $narration = $narration;
        $amount = $amount;

        // $requesttype = 'GETCARDS';
        $requesttype = 'CASH_OUT';

        // $agentCode = "32643218445";
        // $affiliateCode = "EGH";
        // $sourceIp = "10.1.1.1";
        // $pin = "ECOb89b1d4779cb4de#9871785a9f0449c5a";
        // $channel = "MOBILE";
        // $sourceCode = "ECOBANKMOBILE";
        // $ccy = "GHS";

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);
        
        $inputString = $sourceIp . $requestId . $agentCode . $ccy . $senderaccount . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $amount . $pin;

        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $senderaccount . $subagentcode . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $senderaccount . $subagentcode . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $senderaccount . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $subagentcode . $amount . $pin;

        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $sendername . $subagentcode . $senderphone . $senderaccount . $thirdpartyphonenumber . $narration . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $sendername . $subagentcode . $senderphone . $senderaccount . $thirdpartyphonenumber . $narration . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $sendername . $subagentcode . $senderphone . $senderaccount . $thirdpartyphonenumber . $ccy . $narration . $amount . $pin;

        $transactionToken =  hash('sha512', $inputString);

        // Generating the Transaction Token\n\nThe request token is a Hex String generated using the SHA algorithm. The input string for SHA512 is created by concatenating the white listed IP, requestID generated , Agent Code, currency of transaction, destination Account , transaction amount and secret key shared by eprocess.  \n`Destination Account` is `mobile number` for BuyAirtime, `billercode` for postbillpayment and `beneficiary agent code` for Agent to Agent. Amount in transaction token should be in two decimal places irrespctive of the currrency\n\nTransactions with no currency, destination account and amount should be empty string for these fields.


        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $destinationAccount . $amount . $pin;
        // $transactionToken = hash('sha512', $inputString);

        // echo $transactionToken;

        $payload = [
            "sendername" => $sendername,
            "subagentcode" => $subagentcode,
            "senderphone" => $senderphone,
            "senderaccount" => $senderaccount,
            "thirdpartyphonenumber" => $thirdpartyphonenumber,
            "ccy" => $ccy,
            "narration" => $narration,
            "amount" => $amount,

            // "transactiontoken" => $transactionToken,
            "transactiontoken" => "7b926624059513827cb9368246c632deeda816c541c2eb9a0a78dcbf1bdafcb36e862be84420b645cbdf688806539f914175a044dcb762f44530314ab22a4e63",

            "header" => [
                "affcode" => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                "sourceCode" => $sourceCode,
                "sourceIp" => $sourceIp,
                "channel" => $channel,
                "requesttype" => $requesttype,
                "agentcode" => $agentCode
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }

    public function getAccount($accountRefNo, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/getaccount';

        $requestId = $this->generateRequestId();

        // $accountRefNo = "CUPD0000000120982";
        $accountRefNo = $accountRefNo;

        $requesttype = 'GET_ACCOUNT';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);

        // var transactionTokenUnhashed = sourceIp + requestId + agentcode + pin;
        $inputString = $sourceIp . $requestId . $agentCode . $pin;
        $transactionToken =  hash('sha512', $inputString);

        $payload = [
            "transactiontoken" => $transactionToken,
            "accountRefNo" => $accountRefNo,
            'header' => [
                'affcode' => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                'sourceCode' => $sourceCode,
                'sourceIp' => $sourceIp,
                'channel' => $channel,
                'requesttype' => $requesttype,
                'agentcode' => $agentCode,
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }

    public function getAccountStatus($accountRefNo, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/getaccount';

        $requestId = $this->generateRequestId();

        // $accountRefNo = "CUPD0000000120982";
        $accountRefNo = $accountRefNo;

        $requesttype = 'GET_ACCOUNT';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);

        // var transactionTokenUnhashed = sourceIp + requestId + agentcode + pin;
        $inputString = $sourceIp . $requestId . $agentCode . $pin;
        $transactionToken =  hash('sha512', $inputString);

        $payload = [
            "transactiontoken" => $transactionToken,
            "accountRefNo" => $accountRefNo,
            'header' => [
                'affcode' => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                'sourceCode' => $sourceCode,
                'sourceIp' => $sourceIp,
                'channel' => $channel,
                'requesttype' => $requesttype,
                'agentcode' => $agentCode,
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 2);
    }

    public function getAccountBalance() {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/getbalance';
        $url = "https://xpresspoint.ecobank.com/agencybanking/services/thirdpartyagencybanking/getbalance";

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        $requesttype = 'VALIDATE';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);
        $inputString = $sourceIp . $requestId . $agentCode . $ccy . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $pin;
        $transactionToken =  hash('sha512', $inputString);

        $payload = [

            // "transactiontoken" => $transactionToken,
            'transactiontoken' => "7b926624059513827cb9368246c632deeda816c541c2eb9a0a78dcbf1bdafcb36e862be84420b645cbdf688806539f914175a044dcb762f44530314ab22a4e63",

            'header' => [
                'affcode' => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                'sourceCode' => $sourceCode,
                'sourceIp' => $sourceIp,
                'channel' => $channel,
                'requesttype' => $requesttype,
                'agentcode' => $agentCode,
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type = '', $logable_id = 0, $option = 1);
    }

    public function getTransaction($subagentcode, $refno, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/transactionenquiry';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        $refno = $refno;
        $subagentcode = $subagentcode;

        $requesttype = 'VALIDATE';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);

        $inputString = $sourceIp . $requestId . $agentCode . $ccy . $refno . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $pin;
        $transactionToken =  hash('sha512', $inputString);

        $payload = [
            "subagentcode" => $subagentcode,
            "refno" => $refno,

            // "transactiontoken" => $transactiontoken,
            'transactiontoken' => "7b926624059513827cb9368246c632deeda816c541c2eb9a0a78dcbf1bdafcb36e862be84420b645cbdf688806539f914175a044dcb762f44530314ab22a4e63",

            'header' => [
                'affcode' => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                'sourceCode' => $sourceCode,
                'sourceIp' => $sourceIp,
                'channel' => $channel,
                'requesttype' => $requesttype,
                'agentcode' => $agentCode,
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }

    public function getTransactionStatus($subagentcode, $refno, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/transactionenquiry';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        $refno = $refno;
        $subagentcode = $subagentcode;

        $requesttype = 'VALIDATE';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);

        $inputString = $sourceIp . $requestId . $agentCode . $ccy . $refno . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $pin;
        $transactionToken =  hash('sha512', $inputString);

        $payload = [
            "subagentcode" => $subagentcode,
            "refno" => $refno,

            // "transactiontoken" => $transactiontoken,
            'transactiontoken' => "7b926624059513827cb9368246c632deeda816c541c2eb9a0a78dcbf1bdafcb36e862be84420b645cbdf688806539f914175a044dcb762f44530314ab22a4e63",

            'header' => [
                'affcode' => $affiliateCode,
                'requestId' => $requestId,
                'requestToken' => $requestToken,
                'sourceCode' => $sourceCode,
                'sourceIp' => $sourceIp,
                'channel' => $channel,
                'requesttype' => $requesttype,
                'agentcode' => $agentCode,
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 2);
    }

    public function selfTransfer($sourceaccount, $destinationAccount, $amount, $subagent, $logable_type, $logable_id)
    {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/selftransfer';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680";

        // $amount = "10.00";
        // // $destinationAccount = "2151106841";
        // // $destinationAccount = "233501374526";
        // $destinationAccount = "233559148214";
        // $sourceaccount = "0011001594";
        // $subagent = "30012345";

        $amount = $amount;
        $destinationAccount = $destinationAccount;
        $sourceaccount = $sourceaccount;
        $subagent = $subagent;

        $requesttype = 'VALIDATE';

        $agentCode = $this->agentcode;
        $affiliateCode = $this->affcode;
        $sourceIp = $this->sourceIp;
        $pin = $this->pin;
        $channel = $this->channel;
        $sourceCode = $this->sourceCode;
        $ccy = $this->currency;

        $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);


        // \Log::info('Generated Request Token1: ' . $requestToken);

        // $requestToken = $this->generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp);
        // \Log::info('Generated Request Token2: ' . $requestToken);

        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $destinationAccount . $amount . $pin;
        // $transactionToken =  hash('sha512', $inputString);
        // \Log::info('Generated Transaction Token1: ' . $transactionToken);

        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $destinationAccount . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $destinationAccount . $sourceaccount . $subagent . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $sourceaccount . $subagent . $amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $destinationAccount . $sourceaccount .$amount . $pin;
        // $inputString = $sourceIp . $requestId . $agentCode . $ccy . $amount . $pin;
        $inputString = $sourceIp . $requestId . $agentCode . $ccy . $agentCode . $amount . $pin;

        $transactionToken =  hash('sha512', $inputString);
        // \Log::info('Generated Transaction Token2: ' . $transactionToken);

        $nTranToken = "7b926624059513827cb9368246c632deeda816c541c2eb9a0a78dcbf1bdafcb36e862be84420b645cbdf688806539f914175a044dcb762f44530314ab22a4e63";
        // \Log::info('Known Transaction Token: ' . $nTranToken);

        $payload = [
            'sourceaccount' => $sourceaccount,
            'destinationaccount' => $destinationAccount,
            'ccy' => $ccy,
            'amount' => $amount,
            'subagent' => $subagent,

            // 'transactiontoken' => $transactionToken,
            "transactiontoken" => $nTranToken,

            'header' => [
                'affcode' => $affiliateCode,
                'requestId' => $requestId,

                'requestToken' => $requestToken,

                'sourceCode' => $sourceCode,
                'sourceIp' => $sourceIp,
                'channel' => $channel,
                'requesttype' => $requesttype,
                'agentcode' => $agentCode,
            ]
        ];

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }


    protected function generateRequestToken($affiliateCode, $requestId, $agentCode, $sourceCode, $sourceIp) {
        $inputString = $affiliateCode . $requestId . $agentCode . $sourceCode . $sourceIp;
        return hash('sha512', $inputString);
    }

    protected function generateTransactionToken($sourceIp, $requestId, $agentCode, $ccy, $destinationAccount, $amount, $pin) {
        $inputString = $sourceIp . $requestId . $agentCode . $ccy . $destinationAccount . $amount . $pin;
        return hash('sha512', $inputString);
    }

    protected function generateRequestId($length = 16) {
        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $requestId = '';
        for ($i = 0; $i < $length; $i++) {
            $requestId .= $characters[rand(0, $charactersLength - 1)];
        }
        return $requestId;
    }


    // momo
    public function depositMomo($sendername, $subagentcode, $senderphone, $senderaccount, $thirdpartyphonenumber, $narration, $amount, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/cashin';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }

    public function withdrawalMomo($sendername, $subagentcode, $senderphone, $senderaccount, $thirdpartyphonenumber, $narration, $amount, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/cashin';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }

    public function addMomo($sendername, $subagentcode, $senderphone, $senderaccount, $thirdpartyphonenumber, $narration, $amount, $logable_type, $logable_id) {
        $url = $this->baseUrl . 'agencybanking/services/thirdpartyagencybanking/cashin';

        $requestId = $this->generateRequestId();
        $requestId = "A1903200451111434552242345680"; // to be changed

        return $this->postReq($url, $payload, $requestId, $logable_type, $logable_id, $option = 1);
    }


    protected function postReq($url, $payload, $requestId, $logable_type, $logable_id, $option) {
        try {
            $response = Http::withOptions([
                'timeout' => 60, // Increase timeout as needed
                'verify' => false, // Disable SSL verification for testing; ensure to enable in production
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // Ensure using the correct SSL/TLS version
                ],
            ])->post($url, $payload);

            RequestLog::create([
                'user_id' => Auth::id(),
                'app_id' => 1,
                // 'logable_type' => 'PAYMENT',
                // 'logable_id' => 'integer',
                'type' => 1, // main request
                'status' => 2, // success
                'request_id' => $requestId,
                'payload' => json_encode($payload),
                'response' => json_encode($response->json()),
                'request_status' => $response->status(),
                'error_message' => $e->getMessage(),
            ]);

            $user = User::find(Auth::id());
            if (empty($user)) {
                // return $this->sendError('User not found');
                \Log::error('Trans API Error: ' . 'User not found');
            }

            if ($logable_type != '' && $logable_id != 0) { // check acct balance won't pass

                $msg = "";
                $title = "";
                if ($option == 2) { // checking
                    if ($logable_type == 'App\Models\Transaction') {


                        $transaction = Transaction::find($logable_id);
                        if (empty($transaction)) {
                            // return $this->sendError('Transaction not found');
                            \Log::error('Trans API Error: ' . 'Transaction not found');
                        }
                        $transaction->status = 5;
                        $transaction->update();

                        if ($transaction->payment_id) {
                            $payment = Payment::find($transaction->payment_id);
                            if (empty($payment)) {
                                // return $this->sendError('Payment not found');
                                \Log::error('Trans API Error: ' . 'Payment not found');
                            }
                            $payment->status = 5;
                            $payment->update();
                        }

                        $msg = "Your transaction (".$requestId.") update: ". Carbon::now()->toDayDateTimeString();
                        $title = "SIKAFON Transaction Email";
                    } else if ($logable_type == 'App\Models\Account') {

                        $account = AccountUser::find($logable_id);
                        if (empty($account)) {
                            // return $this->sendError('Account not found');
                            \Log::error('Trans API Error: ' . 'Account not found');
                        }
                        // $account->account_no = $response['accountNo']; // balanace
                        // $account->balance = $response['balance'];

                        // $account->account_no = "CUPD0000000016368";
                        $account->status = 1;
                        $account->update();

                        $msg = "Your sikafon account ("."CUPD0000000016368".") update: ". Carbon::now()->toDayDateTimeString();
                        $title = "SIKAFON ACCOUNT Email";
                    }
                } else if ($option == 1) {
                    if ($logable_type == 'App\Models\Transaction') {

                        $transaction = Transaction::find($logable_id);
                        if (empty($transaction)) {
                            // return $this->sendError('Transaction not found');
                            \Log::error('Trans API Error: ' . 'Transaction not found');
                        }
                        $transaction->transaction_code = $requestId;
                        $transaction->status = 1;
                        $transaction->update();

                        if ($transaction->payment_id) {
                            $payment = Payment::find($transaction->payment_id);
                            if (empty($payment)) {
                                // return $this->sendError('Payment not found');
                                \Log::error('Trans API Error: ' . 'Payment not found');
                            }
                            $payment->status = 1;
                            $payment->update();
                        }

                        $msg = "Your transaction (".$requestId.") is being processed: ". Carbon::now()->toDayDateTimeString();
                        $title = "SIKAFON Transaction Email";
                    } else if ($logable_type == 'App\Models\Account') {

                        $account = AccountUser::find($logable_id);
                        if (empty($account)) {
                            // return $this->sendError('Account not found');
                            \Log::error('Trans API Error: ' . 'Account not found');
                        }
                        // $account->account_no = $response['accountRefNo']; // "CUPD0000000016368" create

                        $account->account_no = "CUPD0000000016368";
                        $account->status = 1;
                        $account->update();

                        $msg = "Your sikafon account ("."CUPD0000000016368".") is being processed: ". Carbon::now()->toDayDateTimeString();
                        $title = "SIKAFON ACCOUNT Email";
                    }
                    
                }

                if ($msg != "" && $title != "" && !empty($user)) {
                    DynamicMailJob::dispatch($user, $title, $msg);
                }
            }

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            \Log::error('Request failed: ' . $e->getMessage());

            RequestLog::create([
                'user_id' => Auth::id(),
                'app_id' => 1,
                // 'logable_type' => 'PAYMENT',
                // 'logable_id' => 'integer',
                'type' => 1, // main request
                'status' => 4, // error
                'request_id' => $requestId,
                'payload' => json_encode($payload),
                'request_status' => 'error',
                'error_message' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Request failed', 'message' => $e->getMessage()], 500);
        }
    }


    protected function postCheckReq($url, $payload, $requestId) {
        try {

            $response = Http::withOptions([
                'timeout' => 60, // Increase timeout as needed
                'verify' => false, // Disable SSL verification for testing; ensure to enable in production
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // Ensure using the correct SSL/TLS version
                ],
            ])->post($url, $payload);

            RequestLog::create([
                'user_id' => Auth::id(),
                'app_id' => 1,
                'logable_type' => 'App\Models\AccountUser',
                // 'logable_id' => 'integer',
                'type' => 2, // check trans
                'status' => 2, // success
                'request_id' => $requestId,
                'payload' => json_encode($payload),
                'response' => json_encode($response->json()),
                'request_status' => $response->status(),
                'error_message' => $e->getMessage(),
            ]);

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            \Log::error('Request failed: ' . $e->getMessage());

            RequestLog::create([
                'user_id' => Auth::id(),
                'app_id' => 1,
                // 'logable_type' => 'PAYMENT',
                // 'logable_id' => 'integer',
                'type' => 2, // check trans
                'status' => 4, // error
                'request_id' => $requestId,
                'payload' => json_encode($payload),
                'request_status' => 'error',
                'error_message' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Request failed', 'message' => $e->getMessage()], 500);
        }
    }
}

