<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentAPIRequest;
use App\Http\Requests\API\UpdatePaymentAPIRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PaymentResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helper\Helpers;
use Carbon\Carbon;
use App\Models\Code;
use App\Models\User;
use App\Models\Transaction;
use App\Models\AccountUser;
use App\Models\CardUser;

use App\Services\BankingService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

/**
 * Class PaymentController
 * @package App\Http\Controllers\API
 */

class PaymentAPIController extends AppBaseController
{

    protected $bankingService;
    protected $baseUrl = 'https://localhost:56232';
    // protected $baseUrl = 'https://sikafon.net:5001'; // live

    public function __construct(BankingService $bankingService) {
        $this->bankingService = $bankingService;
    }

    /**
     * Display a listing of the Payment.
     * GET|HEAD /payments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Payment::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $payments = $query->get();

        return $this->sendResponse(PaymentResource::collection($payments), 'Payments retrieved successfully');
    }

    /**
     * Store a newly created Payment in storage.
     * POST /payments
     *
     * @param CreatePaymentAPIRequest $request
     *
     * @return Response
     */

    // for agent
    public function store(Request $request)
    {
        $input = $request->all();

        try {
            // DB::beginTransaction();
            
            $code = Code::where('code', $request->code)
                ->where('codeable_type', 'App\Models\Payment')
                ->first();
            if (empty($code)) {
                return $this->sendError('Code not found');
            }

            $currentDateTime = Carbon::now();
            if ($currentDateTime->greaterThan($code->expired_at)) {
                return $this->sendError('Sorry the code has expired');
            }
            

            $input['user_id'] = Auth::id();
            $input['code_id'] = $code->id;
            $input['qrcode_id'] = $code->id;
            $payment = Payment::create($input);
            // $payment->refresh();

            $transaction = new Transaction();
            $transaction->user_id = Auth::id();
            $transaction->amount = $request->amount;
            $transaction->payment_id = $payment->id;
            $transaction->save();

            $fromAccountUser = User::find($code->user_id);
            if (empty($fromAccountUser)) {
                return $this->sendSuccess('Client not found');
            }

            if (strpos($fromAccountUser->phone, '233') === 0) {
                $phone = '0' . substr($fromAccountUser->phone, 3);
            } else {
                $phone = $fromAccountUser->phone;
            }

            $response = Http::withOptions(['verify' => false])->timeout(30)->get("$this->baseUrl/api/getaccountnumber/from-database", [
                'identityType' => '0',
                'identityNumber' => $fromAccountUser->card_id,
                'phoneNumber' => $phone
            ]);
            
            if ($response->successful()) {
                $accountData = $response->json();
                // \Log::info($accountData);

                // new start
                $loginUrl = "$this->baseUrl/Account/Login";
                $loginResponse = Http::withOptions(['verify' => false])->timeout(30)->post($loginUrl, [
                    'Username' => 'admin',
                    'Password' => 'serenity',
                ]);
                
                if ($loginResponse->successful()) {
                    // Manually extract cookies from headers
                    $cookies = $loginResponse->header('Set-Cookie');
                
                    // Log the cookies to inspect
                    \Log::info('Set-Cookie Header: ' . $cookies);
        
                    $transactionUrl = "$this->baseUrl/Services/Transaction/Transaction/Create";
                
                    // Send these cookies in the next request
                    $transactionResponse = Http::withOptions(['verify' => false])->timeout(10)
                        ->withHeaders([
                            'Cookie' => $cookies // Manually send the cookies here
                        ])
                        ->post($transactionUrl, [
                            "Entity" => [
                                "ClientId" => $accountData["Id"],
                                "TransactionType" => $request->trans_type, // "1", // 2 withdrawal, 1 deposit
                                "Amount" => number_format((float)$request->amount, 2, '.', ''), // "3.00", //1
                                "ClientAccountNumber" => $accountData["AccountNumber"], // ""
                                "SenderPhone" => $accountData["PhoneNumber"], // "",
                                "ClientFirstName" => $accountData["FirstName"], // "",
                                "ClientLastName" => $accountData["LastName"] // ""
                            ]
                        ]);
                
                    return $this->sendResponse(new PaymentResource($payment), 'Payment saved successfully');
                    // if ($transactionResponse->successful()) {
                    //     return $this->sendResponse(new PaymentResource($payment), 'Payment saved successfully');
                    //     return $transactionResponse;
                    // } else {
                    //     return response()->json(['error' => 'Transaction failed'], $transactionResponse->status());
                    // }
                } else {
                    return response()->json(['error' => 'Authentication failed'], $loginResponse->status());
                }
                // new end
            } else {
                $statusCode = $response->status();
                $error = $response->body();
                return $response;
            }

            
        } catch (\Exception $ex) {
            // DB::rollback();
            return $this->sendSuccess($ex->getMessage());
            return $this->sendError($ex->getMessage());
        }
    }


    // for self
    public function wallet (Request $request)
    {
        return $request;
    }

    /**
     * Display the specified Payment.
     * GET|HEAD /payments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Payment $payment */
        $payment = Payment::find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        return $this->sendResponse(new PaymentResource($payment), 'Payment retrieved successfully');
    }

    /**
     * Update the specified Payment in storage.
     * PUT/PATCH /payments/{id}
     *
     * @param int $id
     * @param UpdatePaymentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePaymentAPIRequest $request)
    {
        /** @var Payment $payment */
        $payment = Payment::find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment->fill($request->all());
        $payment->save();

        return $this->sendResponse(new PaymentResource($payment), 'Payment updated successfully');
    }

    /**
     * Remove the specified Payment from storage.
     * DELETE /payments/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Payment $payment */
        $payment = Payment::find($id);

        if (empty($payment)) {
            return $this->sendError('Payment not found');
        }

        $payment->delete();

        return $this->sendSuccess('Payment deleted successfully');
    }

    // for self
    public function account(Request $request)
    {
        $account = UserAccount::where('user_id', Auth::id())->first();

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        // client
        $response = Http::withOptions(['verify' => false])->get("$this->baseUrl/api/getaccountnumber/from-database", [
            'identityType' => '0',
            'identityNumber' => $account->card_id,
            'phoneNumber' => $account->phone
        ]);
        
        if ($response->successful()) {
            $accountData = $response->json();
            // Process the data
            return $this->sendResponse($response, 'Account retrieved successfully');
            return $response;
        } else {
            // Handle error
            $statusCode = $response->status();
            $error = $response->body();
            // Log error or return error response
            return $response;
        }
    }

    // for agent
    public function userAccount(Request $request)
    {
        /** @var Payment $payment */
        $account = UserAccount::where('user_id', Auth::id())->first();

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        // client
        $response = Http::withOptions(['verify' => false])->get("$this->baseUrl/api/getaccountnumber/from-database", [
            'identityType' => '0',
            'identityNumber' => $account->card_id,
            'phoneNumber' => $account->phone
        ]);
        
        if ($response->successful()) {
            $accountData = $response->json();
            // Process the data
            return $this->sendResponse($response, 'Account retrieved successfully');
            return $response;
        } else {
            // Handle error
            $statusCode = $response->status();
            $error = $response->body();
            // Log error or return error response
            return $response;
        }
    }

    public function accounts(Request $request)
    {
        /** @var Payment $payment */
        $accounts = Helpers::getAccounts();

        return $this->sendResponse($accounts, 'Accounts retrieved successfully');
    }

    // for agent
    public function userTransaction(Request $request)
    {
        /** @var Payment $payment */
        $transaction = Transaction::where('code', $request->code)->first();

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        $logable_type == 'App\Models\Transaction';
        $logable_id == 1;

        try {
            $agent = AccountUser::where('user_id', Auth::id())->first();
            if (empty($fromAccountUser)) {
                return $this->sendSuccess('Sender not found');
            }

            $refno = $transaction->code; // 'A181024185637167'
            $subagentcode = $agent->agent_code; // '30012345'

            $response = $this->bankingService->getTransaction($subagentcode, $refno, $logable_type, $logable_id);
            // return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get transaction: ' . $e->getMessage()], 500);
        }

        // $transactions = Helpers::getTransactions($userId, $status);

        return $this->sendResponse($transactions, 'Transactions retrieved successfully');
    }

    public function transactions(Request $request)
    {
        /** @var Payment $payment */

        $user = User::find(Auth::id());
        if (empty($user)) {
            return $this->sendSuccess('Client not found');
        }

        if (strpos($user->phone, '233') === 0) {
            $phone = '0' . substr($user->phone, 3);
        } else {
            $phone = $user->phone;
        }

        // $baseUri = 'https://localhost:56232';
        $response = Http::withOptions(['verify' => false])->timeout(30)->get("$this->baseUrl/api/getaccountnumber/from-database", [
            'identityType' => '0',
            'identityNumber' => $user->card_id,
            'phoneNumber' => $phone
        ]);

        $data = $response->json();
        if (isset($data["Id"])) {
            $id = $data["Id"];
            // return $id;
        } else {
            Log::error('Key "Id" not found in response', ['response' => $data]);
            return $this->sendSuccess('Client not found');
        }

        // \Log::info($user->card_id);
        // \Log::info($user->phone);
        // \Log::info($response);
        
        if ($response->successful()) {
            $accountData = $response->json();
            // transactions
            $url = "$this->baseUrl/api/transactions/by-client-id";

            $response = Http::withOptions(['verify' => false])->timeout(30)->get($url, [
                'clientId' => $id
            ]);
            
            if ($response->successful()) {
                return $this->sendResponse($response->json(), 'Transaction load successfully');
                // return $response->json();
            } else {
                return $response;
                // return response()->json(['error' => 'Unable to fetch transactions'], $response->status());
            }
        } else {
            $statusCode = $response->status();
            $error = $response->body();
            return $response;
        }

        return $this->sendResponse($response, 'Transactions retrieved successfully');
    }


    public function generatePayCode(Request $request) {
        $verificationCode = Helpers::generateVerificationCode();
        
        $qrCodeResult = Helpers::generateQRCode($verificationCode);
    
        if (!$qrCodeResult['success']) {
            return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
        }
    
        $currentDateTime = Carbon::now();
        $expirationDateTime = $currentDateTime->addMinutes(2);
    
        $code = new Code();
        $code->user_id = Auth::id();
        $code->code = $verificationCode;  // Ensure this variable is used
        // $code->url = $qrCodeResult['file_path'];
        $code->url = "storage/codes/". basename($qrCodeResult['file_path']);
        $code->codeable_type = 'App\Models\Payment';
        $code->expired_at = $expirationDateTime;
        $code->save();
    
        return $this->sendResponse($code, 'QR code generated successfully');
    }


    public function generatePayCode1(Request $request) {
        $verificationCode = Helpers::generateVerificationCode();
        
        $qrCodeResult = Helpers::generateAndDecodeQRCode($verificationCode);
    
        if (!$qrCodeResult['success']) {
            return $this->sendError("Failed to generate and decode QR code: " . $qrCodeResult['error']);
        }
    
        return $this->sendResponse([
            'verification_code' => $verificationCode, 
            'file_path' => $qrCodeResult['file_path'],
            'base_name' => basename($qrCodeResult['file_path']),
            'decoded_text' => $qrCodeResult['decoded_text']
        ], 'QR code generated and decoded successfully');
    }

    public function verifyQRCode(Request $request)
    {
        // Validate the request
        $request->validate([
            'qr_code_image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        // Handle the uploaded file
        $file = $request->file('qr_code_image');
        $fileName = 'qr-code-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/scanned_codes', $fileName);

        // Decode the QR code
        try {
            $decodedText = Helpers::decodeQRCode($filePath);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to decode QR code: ' . $e->getMessage()], 400);
        }

        // Check the decoded code in the database
        $code = Code::where('code', $decodedText)->first();

        // return response()->json([
        //     'success' => true, 
        //     'code' => $decodedText,
        //     'filepath' => $filePath,
        // ], 200);

        if (empty($code)) {
            return $this->sendError('Code not found');
        }

        return $this->sendResponse($code, 'QR code verified successfully');

        // if ($code) {
        //     return response()->json(['success' => true, 'code' => $code], 200);
        // } else {
        //     return response()->json(['success' => false, 'message' => 'Code not found.'], 404);
        // }
    }

    
}
