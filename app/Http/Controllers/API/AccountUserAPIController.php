<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAccountUserAPIRequest;
use App\Http\Requests\API\UpdateAccountUserAPIRequest;
use App\Models\AccountUser;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AccountUserResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helper\Helpers;
use App\Models\Code;
use App\Models\User;
use App\Models\Payment;
use App\Models\Transaction;

use Carbon\Carbon;
use App\Jobs\DynamicMailJob;

use App\Services\BankingService;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

/**
 * Class AccountUserController
 * @package App\Http\Controllers\API
 */

class AccountUserAPIController extends AppBaseController
{

    protected $bankingService;
    protected $baseUrl = 'https://localhost:56232';
    // protected $baseUrl = 'https://sikafon.net:5001'; // live

    public function __construct(BankingService $bankingService) {
        $this->bankingService = $bankingService;
    }

    /**
     * Display a listing of the AccountUser.
     * GET|HEAD /accountUsers
     *
     * @param Request $request
     * @return Response
     */
    // public function index(Request $request)
    // {
    //     $query = AccountUser::query();

    //     if ($request->get('skip')) {
    //         $query->skip($request->get('skip'));
    //     }
    //     if ($request->get('limit')) {
    //         $query->limit($request->get('limit'));
    //     }

    //     $accountUsers = $query->get();

    //     return $this->sendResponse(AccountUserResource::collection($accountUsers), 'Account Users retrieved successfully');
    // }

    public function emailAccount(Request $request)
    {

        $user = User::find(Auth::id());
        if (empty($user)) {
            return $this->sendSuccess('User not found');
        }

        if (strpos($user->phone, '233') === 0) {
            $phone = '0' . substr($user->phone, 3);
        } else {
            $phone = $user->phone;
        }

        $response = Http::withOptions(['verify' => false])->timeout(30)->get("$this->baseUrl/api/getaccountnumber/from-database", [
            'identityType' => '0',
            'identityNumber' => $user->card_id,
            'phoneNumber' => $phone
        ]);
        if ($response->successful()) {
            $accountData = $response->json();
            if (isset($accountData["AccountNumber"])) {
                $accountNumber = $accountData["AccountNumber"];
                
                $msg = "Your sikafon user account: ECOBANK EXpress Account NO: (". $accountNumber ."). #SIKAFON ". Carbon::now()->toDayDateTimeString();
                DynamicMailJob::dispatch(auth()->user(), 'SIKAFON ACCOUNT', $msg);
            }

            return $this->sendSuccess('Done successfully');

        } else {
            $statusCode = $response->status();
            $error = $response->body();
            return $this->sendSuccess('Fetched successfully');
            return $response;
        }
    }

    public function index(Request $request)
    {

        $user = User::find(Auth::id());
        if (empty($user)) {
            return $this->sendSuccess('User not found');
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
        if ($response->successful()) {
            $accountData = $response->json();

            $accountUsers = AccountUser::where('user_id', Auth::id())->where('phone', $user->phone)->get();

            return $this->sendResponse(AccountUserResource::collection($accountUsers), 'Account Users retrieved successfully');

        } else {
            $statusCode = $response->status();
            $error = $response->body();
            return $this->sendSuccess('Fetched successfully');
            return $response;
        }
       

        // $accountUsers = AccountUser::where('user_id', Auth::id())->get();

        // return $this->sendResponse(AccountUserResource::collection($accountUsers), 'Account Users retrieved successfully');
    }

    /**
     * Store a newly created AccountUser in storage.
     * POST /accountUsers
     *
     * @param CreateAccountUserAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // DB::beginTransaction();

        $input = $request->all();

        $checkAccountUser = AccountUser::where('user_id', Auth::id())->first();
        if (empty($checkAccountUser)) {

            $genCode = Helpers::generateVerificationCode();
            $qrCodeResult = Helpers::generateQRCode($genCode);
            if (!$qrCodeResult['success']) {
                return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
            }

            $country = 'ghana';
            $phone = Helpers::getIntContact($request->mobileNo, $country);

            $code = new Code();
            $code->user_id = Auth::id();
            $code->code = $genCode;
            $code->url = "storage/codes/". basename($qrCodeResult['file_path']);
            $code->save();

            $accountUser = new AccountUser();
            $accountUser->user_id = Auth::id();
            $accountUser->code_id = $code->id;
            $accountUser->qrcode_id = $code->id;
            $accountUser->name = $request->lastname. ' '.$request->firstname;
            $accountUser->phone = $phone;
            $accountUser->save();

            $code->refresh();

            $codeU = Code::find($code->id);
            $codeU->codeable_type = 'App\Models\AccountUser';
            $codeU->codeable_id = $accountUser->id;
            $codeU->update();

            // new
            $loginUrl = "$this->baseUrl/Account/Login";
            $loginResponse = Http::withOptions(['verify' => false])->timeout(30)->post($loginUrl, [
                'Username' => 'admin',
                'Password' => 'serenity',
            ]);
            
            if ($loginResponse->successful()) {
                // Manually extract cookies from headers
                $cookies = $loginResponse->header('Set-Cookie');
            
                // Log the cookies to inspect
                // \Log::info('Set-Cookie Header: ' . $cookies);

                if (strpos($request->mobileNo, '233') === 0) {
                    $phoneN = '0' . substr($request->mobileNo, 3);
                } else {
                    $phoneN = $request->mobileNo;
                }

                $clientUrl = "$this->baseUrl/Services/Portofolio/Client/Create";
            
                // Send these cookies in the next request
                $clientResponse = Http::withOptions(['verify' => false])->timeout(30)
                    ->withHeaders([
                        'Cookie' => $cookies // Manually send the cookies here
                    ])
                    ->post($clientUrl, [
                        "Entity" => [

                            "FirstName" => $request->firstname,
                            "LastName" => $request->lastname,
                            "MiddleName" => "",
                            "DateOfBirth" => Carbon::parse($request->dateOfBirth)->format('Y-m-d'),
                            "Email" => $request->email,
                            "PhoneNumber" => $phoneN,
                            "Gender" => $request->gender, // "0" male, 1 female,
                            "Address" => $request->address,
                            "CountryCode" => "0",
                            "IdentityType" => "0",
                            "IdentityNumber" => $request->identityNo,
                            "IdentityIssueDate" => Carbon::parse($request->idIssuedDate)->format('Y-m-d'),
                            "IdentityExpiryDate" => Carbon::parse($request->idExpiryDate)->format('Y-m-d')
                        ]
                    ]);
            
                if ($clientResponse->successful()) {
                    return $this->sendResponse(new AccountUserResource($accountUser), 'Account User saved successfully');
                    return $clientResponse;
                } else {
                    return $this->sendSuccess('Submitted successfully');
                    return response()->json(['error' => 'Regsteration failed'], $clientResponse->status());
                }
            } else {
                return response()->json(['error' => 'Authentication failed'], $loginResponse->status());
            }
            // new end
            
            // return $this->sendResponse(new AccountUserResource($accountUser), 'Account User saved successfully');
        } else {
            return $this->sendError('Sorry you already have an account');
        }
        
    }


    public function addAccount(Request $request)
    {
        $input = $request->all();

        $checkAccountUser = AccountUser::where('user_id', Auth::id())->first();
        if (empty($checkAccountUser)) {

            $genCode = Helpers::generateVerificationCode();
            $qrCodeResult = Helpers::generateQRCode($genCode);
            if (!$qrCodeResult['success']) {
                return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
            }

            $code = new Code();
            $code->user_id = Auth::id();
            $code->code = $genCode;
            $code->url = "storage/codes/". basename($qrCodeResult['file_path']);
            $code->save();

            $user = User::find(Auth::id());
            if (empty($user)) {
                return $this->sendSuccess('User not found');
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
            
            // \Log::info($user->card_id);
            // \Log::info($user->phone);
            // \Log::info($response);
            
            if ($response->successful()) {
                $accountData = $response->json();
                // transactions
                $accountUser = new AccountUser();
                $accountUser->user_id = Auth::id();
                $accountUser->code_id = $code->id;
                $accountUser->qrcode_id = $code->id;
                $accountUser->name = $user->last_name. ' '.$user->first_name;
                $accountUser->phone = $user->phone;
                $accountUser->save();

                $code->refresh();

                $codeU = Code::find($code->id);
                $codeU->codeable_type = 'App\Models\AccountUser';
                $codeU->codeable_id = $accountUser->id;
                $codeU->update();

                return $this->sendResponse(new AccountUserResource($accountUser), 'Account User saved successfully');
            } else {
                $statusCode = $response->status();
                $error = $response->body();
                // return $response;
                return $this->sendSuccess('Done successfully');
            }

            return $this->sendResponse(new AccountUserResource($accountUser), 'Account User saved successfully');
        } else {
            return $this->sendError('Sorry you already have an account');
        }
    }

    /**
     * Display the specified AccountUser.
     * GET|HEAD /accountUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AccountUser $accountUser */
        $accountUser = AccountUser::find($id);

        if (empty($accountUser)) {
            return $this->sendError('Account User not found');
        }

        return $this->sendResponse(new AccountUserResource($accountUser), 'Account User retrieved successfully');
    }

    /**
     * Update the specified AccountUser in storage.
     * PUT/PATCH /accountUsers/{id}
     *
     * @param int $id
     * @param UpdateAccountUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountUserAPIRequest $request)
    {
        /** @var AccountUser $accountUser */
        $accountUser = AccountUser::find($id);

        if (empty($accountUser)) {
            return $this->sendError('Account User not found');
        }

        $accountUser->fill($request->all());
        $accountUser->save();

        return $this->sendResponse(new AccountUserResource($accountUser), 'AccountUser updated successfully');
    }


    public function updateAcct(Request $request)
    {
        /** @var AccountUser $accountUser */
        $accountUser = AccountUser::where($request->user_id)->first();

        if (empty($accountUser)) {
            return $this->sendError('Account User not found');
        }

        $accountUser->balance = $accountUser->balance + $request->amount;
        $accountUser->update();

        return $this->sendSuccess('Account User updated succefully');
    }


    public function updateTrans(Request $request)
    {
        $userTrans = Transaction::where(Auth::id())
            ->where('status', '!=', 5)
            ->get();

        if (!empty($userTrans)) {
            foreach ($userTrans as $key => $value) {

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

                    $response = $this->bankingService->getTransactionStatus($subagentcode, $refno, $logable_type, $logable_id);
                    // return response()->json($response);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to get transaction: ' . $e->getMessage()], 500);
                }



                // $acct = Helpers::getTransaction(Auth::id(), $value->id);
                // if ($acct['status'] == true) {
                //     $userAcct = AccountUser::where('user_id', Auth::id())->first();
                //     if (!empty($userAcct)) {


                //         $userAcct->balance = $userAcct->balance + $userTrans->amount;
                //         $userAcct->update();

                //         $userTrans->status = 5;
                //         $userTrans->update();
                //     }
                    
                // }
            }
        }

        return $this->sendSuccess('Account User updated succefully');
    }

    /**
     * Remove the specified AccountUser from storage.
     * DELETE /accountUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AccountUser $accountUser */
        $accountUser = AccountUser::find($id);

        if (empty($accountUser)) {
            return $this->sendError('Account User not found');
        }

        $accountUser->delete();

        return $this->sendSuccess('Account User deleted successfully');
    }
}
