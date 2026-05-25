<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAccountAPIRequest;
use App\Http\Requests\API\UpdateAccountAPIRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AccountResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Log as LogModel;

use App\Http\Resources\AccountUserResource;
use App\Http\Resources\PaymentResource;

use App\Helper\Helpers;


use App\Services\EcobankPayloadService;
use App\Services\EcobankService;

use App\Models\AccountUser;
use App\Models\CardUser;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Pin;
use App\Models\Code;
use App\Models\User;

/**
 * Class AccountController
 * @package App\Http\Controllers\API
 */

class AccountAPIController extends AppBaseController
{
    private EcobankPayloadService $payloadService;
    private EcobankService $ecobankService;

    public function __construct(
        EcobankPayloadService $payloadService,
        EcobankService $ecobankService
    ) {
        $this->payloadService = $payloadService;
        $this->ecobankService = $ecobankService;
    }


    public function openAccount(Request $request)
    {
        DB::beginTransaction();

        try {

            $agent = auth()->user();

            if (!$agent) {
                return $this->sendError(
                    'Authentication required',
                    401
                );
            }

            $user = $agent;

            if (!$user) {
                return $this->sendError(
                    'User not found'
                );
            }

            // Prevent duplicate account opening
            $existingAccount = AccountUser::where(
                'user_id',
                $user->id
            )->first();

            if ($existingAccount) {

                return $this->sendError(
                    'User already has an account'
                );
            }

            $verifiedCard = CardUser::where(
                'card_no',
                $user->card_id
            )->first();

            if (!$verifiedCard) {

                return $this->sendError(
                    'Card must be verified before account creation'
                );
            }


            // verification
            $selfiePath = storage_path(
                'app/public/' . $verifiedCard->live_selfie
            );

            if (!file_exists($selfiePath)) {
                return $this->sendError(
                    'Saved selfie not found'
                );
            }

            $image = base64_encode(
                file_get_contents($selfiePath)
            );

            $verificationPayload =
                $this->payloadService
                    ->buildValidateIdentityPayload([

                        'idNumber' =>
                            $verifiedCard->card_no,

                        'base64Image' =>
                            $image,
                    ]);

            $verificationResponse =
                $this->ecobankService->post(
                    'validateidentity',
                    $verificationPayload
                );

            if (
                data_get(
                    $verificationResponse,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $verificationResponse,
                        'response.header.responsemessage',
                        'Identity verification failed'
                    )
                );
            }

            $transactionGuid = data_get(
                $verificationResponse,
                'response.transactionGuid'
            );

            // 




            $payload =
                $this->payloadService
                    ->buildCreateAccountPayload([

                        'firstname' =>
                            $user->first_name,

                        'lastname' =>
                            $user->last_name,

                        'middlename' =>
                            $user->middle_name,

                        'dateOfBirth' =>
                            Carbon::parse(
                                $user->dob
                            )->format('Y-m-d'),

                        'identityType' =>
                            'GHANA_CARD',

                        'identityNo' =>
                            $verifiedCard->card_no,

                        'idIssueDate' =>
                            Carbon::parse(
                                $verifiedCard->issued_at
                            )->format('Y-m-d'),

                        'idExpiryDate' =>
                            Carbon::parse(
                                $verifiedCard->expired_at
                            )->format('Y-m-d'),

                        'mobileNo' =>
                            $user->phone,

                        'email' =>
                            $user->email,

                        'gender' =>
                            $user->sex,

                        'address' =>
                            $user->address,

                        'countryCode' =>
                            'GH',

                        'transactionGuid' => $transactionGuid,

                        'id' =>
                            'CUS-' . time(),
                    ]);

            $response =
                $this->ecobankService->post(
                    'createaccount',
                    $payload
                );

            if (
                !data_get($response, 'success')
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Unable to connect to Ecobank'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Account creation failed'
                    )
                );
            }

            $accountNumber =
                data_get(
                    $response,
                    'response.accountNumber'
                );

            $accountRefNo =
                data_get(
                    $response,
                    'response.accountRefNo'
                );

            $accountUser = AccountUser::create([

                'user_id' =>
                    $user->id,

                'name' =>
                    $user->first_name .
                    ' ' .
                    $user->last_name,

                'phone' =>
                    $user->phone,

                'account_no' =>
                    $accountNumber,

                'account_ref' =>
                    $accountRefNo ?? $transactionGuid,

                'agent_code' => $agent->code,
            ]);

            // Activity log
            LogModel::create([

                'user_id' =>
                    $agent->id,

                'logable_type' =>
                    'App\Models\AccountUser',

                'logable_id' =>
                    $accountUser->id,

                'about' =>
                    'Self opened Ecobank account by user',
            ]);

            DB::commit();

            return $this->sendResponse(
                [
                    'account' => $accountUser,
                    'ecobank' => $response['response'],
                ],
                'Account created successfully'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function openAccountAgent($id)
    {
        DB::beginTransaction();

        try {

            $agent = auth()->user();

            if (!$agent) {
                return $this->sendError(
                    'Authentication required',
                    401
                );
            }

            // Optional:
            // if ($agent->user_type !== 'agent') {
            //     return $this->sendError('Unauthorized');
            // }

            $user = User::find($id);

            if (!$user) {
                return $this->sendError(
                    'User not found'
                );
            }

            // Prevent duplicate account opening
            $existingAccount = AccountUser::where(
                'user_id',
                $user->id
            )->first();

            if ($existingAccount) {

                return $this->sendError(
                    'User already has an account'
                );
            }

            $verifiedCard = CardUser::where(
                'card_no',
                $user->card_id
            )->first();

            if (!$verifiedCard) {

                return $this->sendError(
                    'Card must be verified before account creation'
                );
            }


            // verification
            $selfiePath = storage_path(
                'app/public/' . $verifiedCard->live_selfie
            );

            if (!file_exists($selfiePath)) {
                return $this->sendError(
                    'Saved selfie not found'
                );
            }

            $image = base64_encode(
                file_get_contents($selfiePath)
            );

            $verificationPayload =
                $this->payloadService
                    ->buildValidateIdentityPayload([

                        'idNumber' =>
                            $verifiedCard->card_no,

                        'base64Image' =>
                            $image,
                    ]);

            $verificationResponse =
                $this->ecobankService->post(
                    'validateidentity',
                    $verificationPayload
                );

            if (
                data_get(
                    $verificationResponse,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $verificationResponse,
                        'response.header.responsemessage',
                        'Identity verification failed'
                    )
                );
            }

            $transactionGuid = data_get(
                $verificationResponse,
                'response.transactionGuid'
            );

            // 


            $payload =
                $this->payloadService
                    ->buildCreateAccountPayload([

                        'firstname' =>
                            $user->first_name,

                        'lastname' =>
                            $user->last_name,

                        'middlename' =>
                            $user->middle_name,

                        'dateOfBirth' =>
                            Carbon::parse(
                                $user->dob
                            )->format('Y-m-d'),

                        'identityType' =>
                            'GHANA_CARD',

                        'identityNo' =>
                            $verifiedCard->card_no,

                        'idIssueDate' =>
                            Carbon::parse(
                                $verifiedCard->issued_at
                            )->format('Y-m-d'),

                        'idExpiryDate' =>
                            Carbon::parse(
                                $verifiedCard->expired_at
                            )->format('Y-m-d'),

                        'mobileNo' =>
                            $user->phone,

                        'email' =>
                            $user->email,

                        'gender' =>
                            $user->sex,

                        'address' =>
                            $user->address,

                        'countryCode' =>
                            'GH',

                        'transactionGuid' => $transactionGuid,

                        'id' =>
                            'CUS-' . time(),
                    ]);

            $response =
                $this->ecobankService->post(
                    'createaccount',
                    $payload
                );

            if (
                !data_get($response, 'success')
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Unable to connect to Ecobank'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Account creation failed'
                    )
                );
            }

            $accountNumber =
                data_get(
                    $response,
                    'response.accountNumber'
                );

            $accountRefNo =
                data_get(
                    $response,
                    'response.accountRefNo'
                );

            $accountUser = AccountUser::create([

                'user_id' =>
                    $user->id,

                'name' =>
                    $user->first_name .
                    ' ' .
                    $user->last_name,

                'phone' =>
                    $user->phone,

                'account_no' =>
                    $accountNumber,

                'account_ref' =>
                    $accountRefNo ?? $transactionGuid,

                'agent_code' => $agent->code,
            ]);

            // Activity log
            LogModel::create([

                'user_id' =>
                    $agent->id,

                'logable_type' =>
                    'App\Models\AccountUser',

                'logable_id' =>
                    $accountUser->id,

                'about' =>
                    'Agent opened Ecobank account for user',
            ]);

            DB::commit();

            return $this->sendResponse(
                [
                    'account' => $accountUser,
                    'ecobank' => $response['response'],
                ],
                'Account created successfully'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function addAccountAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required|string',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                $validator->errors()->first()
            );
        }

        DB::beginTransaction();

        try {

            $agent = auth()->user();

            if (!$agent) {
                return $this->sendError(
                    'Authentication required',
                    401
                );
            }

            $user = User::find($request->id);

            if (!$user) {
                return $this->sendError(
                    'User not found'
                );
            }

            $existing = AccountUser::where(
                'user_id',
                $user->id
            )->first();

            if ($existing) {
                return $this->sendError(
                    'User already has an account'
                );
            }

            // Validate account from Ecobank
            $payload =
                $this->payloadService
                    ->buildGetAccountPayload(
                        $request->account_number
                    );

            $response =
                $this->ecobankService->post(
                    'getcustomerdetails',
                    $payload
                );

            if (!data_get($response, 'success')) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Failed to connect to Ecobank'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Unable to fetch account'
                    )
                );
            }

            $accountData =
                data_get($response, 'response');

            // Generate QR code
            $genCode =
                Helpers::generateVerificationCode();

            $qrCodeResult =
                Helpers::generateQRCode($genCode);

            if (!$qrCodeResult['success']) {

                DB::rollBack();

                return $this->sendError(
                    'Failed to generate QR code'
                );
            }

            $code = Code::create([
                'user_id' => $user->id,
                'code' => $genCode,
                'url' => 'storage/codes/' .
                    basename($qrCodeResult['file_path']),
            ]);

            // Save account
            $accountUser = AccountUser::create([

                'user_id' => $user->id,

                'code_id' => $code->id,

                'qrcode_id' => $code->id,

                'name' =>
                    $user->last_name .
                    ' ' .
                    $user->first_name,

                'phone' => $user->phone,

                'account_no' =>
                    data_get(
                        $accountData,
                        'accountNumber',
                        $request->account_number
                    ),

                'account_ref' =>
                    data_get(
                        $accountData,
                        'accountRefNo'
                    ),

                'agent_code' =>
                    $agent->code,
            ]);

            $code->update([
                'codeable_type' =>
                    'App\Models\AccountUser',

                'codeable_id' =>
                    $accountUser->id,
            ]);


            // Activity log
            LogModel::create([

                'user_id' =>
                    $agent->id,

                'logable_type' =>
                    'App\Models\AccountUser',

                'logable_id' =>
                    $accountUser->id,

                'about' =>
                    'Agent added Ecobank account for user',
            ]);

            DB::commit();

            return $this->sendResponse(
                new AccountUserResource($accountUser),
                'Account linked successfully'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }

    public function addAccountSelf(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                $validator->errors()->first()
            );
        }

        DB::beginTransaction();

        try {

            $agent = auth()->user();

            if (!$agent) {
                return $this->sendError(
                    'Authentication required',
                    401
                );
            }

            $user = $agent;

            if (!$user) {
                return $this->sendError(
                    'User not found'
                );
            }

            $existing = AccountUser::where(
                'user_id',
                $user->id
            )->first();

            //////////////////////////////////////////////  ownership test

            if ($existing) {
                return $this->sendError(
                    'User already has an account'
                );
            }

            // Validate account from Ecobank
            $payload =
                $this->payloadService
                    ->buildGetAccountPayload(
                        $request->account_number
                    );

            $response =
                $this->ecobankService->post(
                    'getcustomerdetails',
                    $payload
                );

            if (!data_get($response, 'success')) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Failed to connect to Ecobank'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Unable to fetch account'
                    )
                );
            }

            $accountData =
                data_get($response, 'response');

            // Generate QR code
            $genCode =
                Helpers::generateVerificationCode();

            $qrCodeResult =
                Helpers::generateQRCode($genCode);

            if (!$qrCodeResult['success']) {

                DB::rollBack();

                return $this->sendError(
                    'Failed to generate QR code'
                );
            }

            $code = Code::create([
                'user_id' => $user->id,
                'code' => $genCode,
                'url' => 'storage/codes/' .
                    basename($qrCodeResult['file_path']),
            ]);

            // Save account
            $accountUser = AccountUser::create([

                'user_id' => $user->id,

                'code_id' => $code->id,

                'qrcode_id' => $code->id,

                'name' =>
                    $user->last_name .
                    ' ' .
                    $user->first_name,

                'phone' => $user->phone,

                'account_no' =>
                    data_get(
                        $accountData,
                        'accountNumber',
                        $request->account_number
                    ),

                'account_ref' =>
                    data_get(
                        $accountData,
                        'accountRefNo'
                    ),

                'agent_code' =>
                    $agent->code,
            ]);

            $code->update([
                'codeable_type' =>
                    'App\Models\AccountUser',

                'codeable_id' =>
                    $accountUser->id,
            ]);


            // Activity log
            LogModel::create([

                'user_id' =>
                    $agent->id,

                'logable_type' =>
                    'App\Models\AccountUser',

                'logable_id' =>
                    $accountUser->id,

                'about' =>
                    'Self added Ecobank account by user',
            ]);

            DB::commit();

            return $this->sendResponse(
                new AccountUserResource($accountUser),
                'Account linked successfully'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function getAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                $validator->errors()->first()
            );
        }

        // first check local account
        $accountUser = AccountUser::where(
            'account_ref',
            $request->account_number
        )
        ->orWhere(
            'account_no',
            $request->account_number
        )
        ->first();

        $payload =
            $this->payloadService
                ->buildSyncAccountPayload(
                    $request->account_number
                );

        $response =
            $this->ecobankService->post(
                'getaccount',
                $payload
            );

        \Log::info([
            'get_account_response' => $response
        ]);

        if (
            !data_get($response, 'success')
        ) {

            return $this->sendError(
                data_get(
                    $response,
                    'message',
                    'Failed to connect to Ecobank'
                )
            );
        }

        if (
            data_get(
                $response,
                'response.header.responsecode'
            ) !== '000'
        ) {

            return $this->sendError(
                data_get(
                    $response,
                    'response.header.responsemessage',
                    'Unable to fetch account'
                )
            );
        }

        // Ecobank may return either accountNumber or accountNo
        $accountNumber =
            data_get(
                $response,
                'response.accountNumber'
            ) ?:
            data_get(
                $response,
                'response.accountNo'
            );

        // auto sync local record if missing
        if (
            $accountUser &&
            empty($accountUser->account_no) &&
            !empty($accountNumber)
        ) {

            $accountUser->update([
                'account_no' => $accountNumber,
            ]);

            $accountUser->refresh();
        }

        return $this->sendResponse(
            [
                'ecobank' => data_get(
                    $response,
                    'response'
                ),

                'local_account' => $accountUser,
            ],
            'Account retrieved successfully'
        );
    }

    public function syncAccounts(Request $request)
    {
        try {

            $accounts = AccountUser::whereNull(
                'account_no'
            )
            ->whereNotNull(
                'account_ref'
            )
            ->get();

            $updated = [];
            $pending = [];

            foreach ($accounts as $accountUser) {

                try {

                    $payload =
                        $this->payloadService
                            ->buildSyncAccountPayload(
                                $accountUser->account_ref
                            );

                    $response =
                        $this->ecobankService->post(
                            'getaccount',
                            $payload
                        );

                    \Log::info([
                        'sync_account_response' => $response
                    ]);

                    if (
                        !data_get($response, 'success')
                    ) {

                        $pending[] = [
                            'account_ref' =>
                                $accountUser->account_ref,

                            'reason' =>
                                data_get(
                                    $response,
                                    'message',
                                    'Failed connecting'
                                ),
                        ];

                        continue;
                    }

                    if (
                        data_get(
                            $response,
                            'response.header.responsecode'
                        ) !== '000'
                    ) {

                        $pending[] = [
                            'account_ref' =>
                                $accountUser->account_ref,

                            'reason' =>
                                data_get(
                                    $response,
                                    'response.header.responsemessage',
                                    'Not ready yet'
                                ),
                        ];

                        continue;
                    }

                    // Ecobank may return either field
                    $accountNumber =
                        data_get(
                            $response,
                            'response.accountNumber'
                        ) ?:
                        data_get(
                            $response,
                            'response.accountNo'
                        );

                    if (empty($accountNumber)) {

                        $pending[] = [
                            'account_ref' =>
                                $accountUser->account_ref,

                            'reason' =>
                                'Account number not generated yet',
                        ];

                        continue;
                    }

                    $accountUser->update([
                        'account_no' => $accountNumber,
                    ]);

                    $updated[] = [
                        'account_ref' =>
                            $accountUser->account_ref,

                        'account_no' =>
                            $accountNumber,
                    ];

                } catch (\Throwable $e) {

                    \Log::error($e);

                    $pending[] = [
                        'account_ref' =>
                            $accountUser->account_ref,

                        'reason' =>
                            $e->getMessage(),
                    ];
                }
            }

            return $this->sendResponse(
                [
                    'updated' => $updated,
                    'pending' => $pending,
                ],
                'Account sync completed'
            );

        } catch (\Throwable $e) {

            \Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function newTransaction(Request $request) {

        DB::beginTransaction();

        try {

            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1',
                'senderaccount' => 'required',
                'senderphone' => 'required',
                'thirdpartyphonenumber' => 'required',
                'sendername' => 'required',
                'code' => 'required',
                'trans' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError(
                    $validator->errors()->first()
                );
            }



            $agent = auth()->user();

            if (!$agent) {
                return $this->sendError(
                    'Authentication required',
                    401
                );
            }

            $accountUser = AccountUser::where(
                'account_no',
                $request->senderaccount
            )->first();

            if (!$accountUser) {

                DB::rollBack();

                return $this->sendError(
                    'Account not found'
                );
            }



            $code = Code::where(
                'code',
                $request->code
            )
            ->where(
                'codeable_type',
                'App\Models\Payment'
            )
            ->where('user_id', $accountUser->user_id)
            ->first();

            if (empty($code)) {
                return $this->sendError(
                    'Code not found'
                );
            }

            if (
                Carbon::now()->greaterThan(
                    $code->expired_at
                )
            ) {

                return $this->sendError(
                    'Sorry the code has expired'
                );
            }



            if ($request->trans == 'CASH_OUT') {

                $payload = $this->payloadService
                    ->buildWithdrawalPayload([
                        'amount' => $request->amount,
                        'senderaccount' => $request->senderaccount,
                        'senderphone' => $accountUser->phone,
                    ]);

                $response = $this->ecobankService
                    ->post('withdrawal', $payload);

            } else {

                $payload = $this->payloadService
                    ->buildCashInPayload([
                        'amount' => $request->amount,
                        'senderaccount' => $request->senderaccount,
                        'senderphone' => $accountUser->phone,
                        'thirdpartyphonenumber' => $accountUser->phone,
                        'sendername' => $accountUser->name,
                        'narration' => 'Cash In Transaction',
                    ]);

                $response = $this->ecobankService
                    ->post('cashin', $payload);
            }

            

            if (
                !data_get($response, 'success')
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Transaction failed'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Transaction failed'
                    )
                );
            }



            $amount = number_format(
                (float) $request->amount,
                2,
                '.',
                ''
            );

            $payment = Payment::create([
                'user_id' => $accountUser->user_id,
                'code_id' => $code->id,
                'qrcode_id' => $code->id,
                'amount' => $amount,
            ]);

            $transaction = Transaction::create([
                'user_id' => $accountUser->user_id,
                'amount' => $amount,

                'code' => $code->code,
                'session_code' => data_get(
                    $response,
                    'response.header.requestId'
                ),

                'transaction_code' => data_get(
                    $response,
                    'response.cbareferenceno'
                ),

                'payment_id' => $payment->id,
                'type' =>  $request->trans == 'CASH_OUT' ? 1 : 0,
            ]);


            // Activity log
            LogModel::create([

                'user_id' =>
                    $agent->id,

                'logable_type' =>
                    'App\Models\Transaction',

                'logable_id' =>
                    $transaction->id,

                'about' =>
                    'Agent transaction for user('.$request->trans.')',
            ]);


            $code->delete();


            DB::commit();

            return $this->sendResponse(
                [
                    'payment' => new PaymentResource($payment),
                    'ecobank' => $response['response']
                ],
                'Transaction successful'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function agentTransaction(Request $request) {

        DB::beginTransaction();

        try {

            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1',
                'senderaccount' => 'required',
                'code' => 'required',
                'trans' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError(
                    $validator->errors()->first()
                );
            }



            $agent = auth()->user();

            if (!$agent) {
                return $this->sendError(
                    'Authentication required',
                    401
                );
            }

            $accountUser = AccountUser::where(
                'account_no',
                $request->senderaccount
            )->first();

            if (!$accountUser) {

                DB::rollBack();

                return $this->sendError(
                    'Account not found'
                );
            }



            $code = Code::where(
                'code',
                $request->code
            )
            ->where(
                'codeable_type',
                'App\Models\Payment'
            )
            ->where('user_id', $accountUser->user_id)
            ->first();

            if (empty($code)) {
                return $this->sendError(
                    'Code not found'
                );
            }

            if (
                Carbon::now()->greaterThan(
                    $code->expired_at
                )
            ) {

                return $this->sendError(
                    'Sorry the code has expired'
                );
            }



            if ($request->trans == 'CASH_OUT') {

                $payload = $this->payloadService
                    ->buildWithdrawalPayload([
                        'amount' => $request->amount,
                        'senderaccount' => $request->senderaccount,
                        'senderphone' => $accountUser->phone,
                    ]);

                $response = $this->ecobankService
                    ->post('withdrawal', $payload);

            } else {

                $payload = $this->payloadService
                    ->buildCashInPayload([
                        'amount' => $request->amount,
                        'senderaccount' => $request->senderaccount,
                        'senderphone' => $accountUser->phone,
                        'thirdpartyphonenumber' => $accountUser->phone,
                        'sendername' => $accountUser->name,
                        'narration' => 'Cash In Transaction',
                    ]);

                $response = $this->ecobankService
                    ->post('cashin', $payload);
            }


            if (
                !data_get($response, 'success')
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Transaction failed'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                DB::rollBack();

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Transaction failed'
                    )
                );
            }


            $amount = number_format(
                (float) $request->amount,
                2,
                '.',
                ''
            );

            $payment = Payment::create([
                'user_id' => $accountUser->user_id,
                'code_id' => $code->id,
                'qrcode_id' => $code->id,
                'amount' => $amount,
            ]);

            $transaction = Transaction::create([
                'user_id' => $accountUser->user_id,
                'amount' => $amount,

                'code' => $code->code,
                'session_code' => data_get(
                    $response,
                    'response.header.requestId'
                ),

                'transaction_code' => data_get(
                    $response,
                    'response.cbareferenceno'
                ),

                'payment_id' => $payment->id,
                'type' =>  $request->trans == 'CASH_OUT' ? 1 : 0,
            ]);


            // Activity log
            LogModel::create([

                'user_id' =>
                    $agent->id,

                'logable_type' =>
                    'App\Models\Transaction',

                'logable_id' =>
                    $transaction->id,

                'about' =>
                    'Agent transaction for user('.$request->trans.')',
            ]);


            $code->delete();


            DB::commit();

            return $this->sendResponse(
                [
                    'payment' => new PaymentResource($payment),
                    'ecobank' => $response['response']
                ],
                'Transaction successful'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function emailAccount(Request $request)
    {
        try {

            $accountUser = AccountUser::where(
                'user_id',
                Auth::id()
            )->first();

            if (empty($accountUser)) {
                return $this->sendError(
                    'Account not found'
                );
            }

            $payload =
                $this->payloadService
                    ->buildGetAccountPayload(
                        $accountUser->account_number
                    );

            $response =
                $this->ecobankService->post(
                    'getcustomerdetails',
                    $payload
                );

            if (
                !data_get($response, 'success')
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Failed to connect to Ecobank'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Unable to retrieve account'
                    )
                );
            }

            $accountNumber =
                data_get(
                    $response,
                    'response.accountno'
                ) ??
                $accountUser->account_number;

            $msg =
                "Your SIKAFON Ecobank Account Number is: "
                . $accountNumber .
                ". " .
                Carbon::now()->toDayDateTimeString();

            DynamicMailJob::dispatch(
                auth()->user(),
                'SIKAFON ACCOUNT',
                $msg
            );

            return $this->sendSuccess(
                'Account emailed successfully'
            );

        } catch (\Throwable $e) {

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }

    // balance from ecobank

    // get acct number for newly opened from ecobank

    // transactions from ecobank

    // agent transactions from ecobank

    // transaction status from ecobank

    // momo

    // remitance


    // self account
    public function account(Request $request)
    {
        try {

            $accountUser = AccountUser::where(
                'user_id',
                Auth::id()
            )->first();

            if (empty($accountUser)) {

                return $this->sendError(
                    'Account not found'
                );
            }

            $payload =
                $this->payloadService
                    ->buildGetAccountPayload(
                        $accountUser->account_number
                    );

            $response =
                $this->ecobankService->post(
                    'getcustomerdetails',
                    $payload
                );

            if (
                !data_get($response, 'success')
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Failed to connect to Ecobank'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Unable to retrieve account'
                    )
                );
            }

            return $this->sendResponse(
                data_get($response, 'response'),
                'Account retrieved successfully'
            );

        } catch (\Throwable $e) {

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    // agent fetch another account
    public function userAccount(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'account_number' => 'required',
            ]
        );

        if ($validator->fails()) {

            return $this->sendError(
                $validator->errors()->first()
            );
        }

        try {

            $payload =
                $this->payloadService
                    ->buildGetAccountPayload(
                        $request->account_number
                    );

            $response =
                $this->ecobankService->post(
                    'getcustomerdetails',
                    $payload
                );

            if (
                !data_get($response, 'success')
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Failed to connect to Ecobank'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Unable to retrieve account'
                    )
                );
            }

            return $this->sendResponse(
                data_get($response, 'response'),
                'Account retrieved successfully'
            );

        } catch (\Throwable $e) {

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function accounts(Request $request)
    {
        $query =  AccountUser::with('user');


        /* ----------------------------------------------------------
            1. SEARCH KEYWORD
        ----------------------------------------------------------- */
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%");
            });

        }


        /* ----------------------------------------------------------
            5. SORTING
        ----------------------------------------------------------- */
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'price_asc':
                    $query->orderBy('amount', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('amount', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        /* ----------------------------------------------------------
            6. PAGINATION
        ----------------------------------------------------------- */
        $limit = $request->get('limit', 20);
        $data = $query->paginate($limit);


        /* ----------------------------------------------------------
            7. RESPONSE
        ----------------------------------------------------------- */
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data,
            'meta' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ]
        ]);
    }


    public function userTransaction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'transaction_id' => 'required',
            ]
        );

        if ($validator->fails()) {

            return $this->sendError(
                $validator->errors()->first()
            );
        }

        $transaction = Transaction::find(
            $request->transaction_id
        );

        if (empty($transaction)) {

            return $this->sendError(
                'Transaction not found'
            );
        }

        return $this->sendResponse(
            $transaction,
            'Transaction retrieved successfully'
        );
    }


    public function adminTransactions(Request $request)
    {
        $query =  Transaction::with('user', 'log');


        /* ----------------------------------------------------------
            1. SEARCH KEYWORD
        ----------------------------------------------------------- */
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%");
            });

        }


        /* ----------------------------------------------------------
            5. SORTING
        ----------------------------------------------------------- */
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'price_asc':
                    $query->orderBy('amount', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('amount', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        /* ----------------------------------------------------------
            6. PAGINATION
        ----------------------------------------------------------- */
        $limit = $request->get('limit', 20);
        $data = $query->paginate($limit);


        /* ----------------------------------------------------------
            7. RESPONSE
        ----------------------------------------------------------- */
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data,
            'meta' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ]
        ]);
    }


    public function events(Request $request)
    {
        $query =  LogModel::with('user', 'logable');


        /* ----------------------------------------------------------
            1. SEARCH KEYWORD
        ----------------------------------------------------------- */
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('about', 'like', "%{$keyword}%");
            });

        }


        /* ----------------------------------------------------------
            5. SORTING
        ----------------------------------------------------------- */
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'price_asc':
                    $query->orderBy('amount', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('amount', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        /* ----------------------------------------------------------
            6. PAGINATION
        ----------------------------------------------------------- */
        $limit = $request->get('limit', 20);
        $data = $query->paginate($limit);


        /* ----------------------------------------------------------
            7. RESPONSE
        ----------------------------------------------------------- */
        return response()->json([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data,
            'meta' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ]
        ]);
    }


    public function generatePayCode(Request $request)
    {
        try {

            $verificationCode =
                Helpers::generateVerificationCode();

            $qrCodeResult =
                Helpers::generateQRCode(
                    $verificationCode
                );

            if (
                !$qrCodeResult['success']
            ) {

                return $this->sendError(
                    'Failed to generate QR code'
                );
            }

            $code = Code::create([

                'user_id' =>
                    Auth::id(),

                'code' =>
                    $verificationCode,

                'url' =>
                    'storage/codes/' .
                    basename(
                        $qrCodeResult['file_path']
                    ),

                'codeable_type' =>
                    'App\Models\Payment',

                'expired_at' =>
                    Carbon::now()
                        ->addMinutes(2),
            ]);

            return $this->sendResponse(
                $code,
                'QR code generated successfully'
            );

        } catch (\Throwable $e) {

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    public function verifyQRCode(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'qr_code_image' =>
                    'required|image|mimes:jpeg,png,jpg',
            ]
        );

        if ($validator->fails()) {

            return $this->sendError(
                $validator->errors()->first()
            );
        }

        try {

            $file = $request->file(
                'qr_code_image'
            );

            $fileName =
                'qr-code-' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();

            $filePath =
                $file->storeAs(
                    'public/scanned_codes',
                    $fileName
                );

            $decodedText =
                Helpers::decodeQRCode(
                    $filePath
                );

            $code = Code::where(
                'code',
                $decodedText
            )->first();

            if (empty($code)) {

                return $this->sendError(
                    'Code not found'
                );
            }

            if (
                Carbon::now()->greaterThan(
                    $code->expired_at
                )
            ) {

                return $this->sendError(
                    'QR code expired'
                );
            }

            return $this->sendResponse(
                $code,
                'QR code verified successfully'
            );

        } catch (\Throwable $e) {

            Log::error($e);

            return $this->sendError(
                'Failed to verify QR code'
            );
        }
    }


    public function verifyCard(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'live_selfie' => 'required|image|mimes:jpeg,png,jpg',
                'card_no' => 'required',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date',
                'id_type' => 'required',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
            ]
        );

        if ($validator->fails()) {

            return $this->sendError(
                $validator->errors()->first()
            );
        }

        if (!$request->hasFile('live_selfie')) {
            return $this->sendError("Selfie is required for card verification");
        }

        try {

            $image =
                base64_encode(
                    file_get_contents(
                        $request->file(
                            'live_selfie'
                        )->getRealPath()
                    )
                );

            $path = $request->file('live_selfie')
                ->store('live_selfies', 'public');

            $payload =
                $this->payloadService
                    ->buildValidateIdentityPayload([

                        'idNumber' =>
                            $request->card_no,

                        'base64Image' =>
                            $image,
                    ]);

            $response =
                $this->ecobankService->post(
                    'validateidentity',
                    $payload
                );

            if (
                !data_get($response, 'success')
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'message',
                        'Verification failed'
                    )
                );
            }

            if (
                data_get(
                    $response,
                    'response.header.responsecode'
                ) !== '000'
            ) {

                return $this->sendError(
                    data_get(
                        $response,
                        'response.header.responsemessage',
                        'Card verification failed'
                    )
                );
            }

            // $apiFirstName = strtoupper(trim(data_get($response, 'firstName')));
            // $apiLastName  = strtoupper(trim(data_get($response, 'lastname')));

            // $userFirstName = strtoupper(trim($request->first_name));
            // $userLastName  = strtoupper(trim($request->last_name));

            // if ($apiFirstName !== $userFirstName || $apiLastName !== $userLastName) {
            //     return $this->sendError("Name mismatch between ID and provided details");
            // }

            $verification = CardUser::create([

                'user_id' => Auth::id(),

                'card_no' => $request->card_no,

                'id_type' => $request->id_type,

                'issued_at' => $request->issue_date,

                'expired_at' => $request->expiry_date,

                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'live_selfie' => $path, // saved the live_selfie to storage/public/app/live_selfie
            ]);

            // return $this->sendResponse(
            //     data_get($response, 'response'),
            //     'Card verified successfully'
            // );

            // \Log::info(data_get($response, 'response'));

            return $this->sendResponse([
                'verification_id' => $verification->id,
            ], 'Card verified successfully');

        } catch (\Throwable $e) {

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }


    //////
    public function myAccount(Request $request)
    {
        $accountUser = AccountUser::where('user_id', Auth::id())->first();

        if (empty($accountUser)) {

            return $this->sendError(
                'Account not found'
            );
        }

        return $this->sendResponse(
            $accountUser,
            'Account retrieved successfully'
        );
    }

    public function myTransactions(Request $request)
    {
        $transactions = Transaction::with('user')->where('user_id', Auth::id())
            ->latest()
            ->take(100)
            ->get();

        return $this->sendResponse(
            $transactions,
            'Transactions retrieved successfully'
        );
    }


    public function agentTransactions(Request $request)
    {
        $logData = LogModel::where('logable_type', 'App\Models\Transaction')
            ->where('user_id', Auth::id())
            ->pluck('id');

        $transactions = Transaction::with('user')
            ->whereIn('id', $logData)
            ->latest()
            ->take(100)
            ->get();

        return $this->sendResponse(
            $transactions,
            'Transactions retrieved successfully'
        );
    }

    public function agentCheckAccount($id)
    {
        $accountUser = AccountUser::where('account_no', $id)->first();

        if (empty($accountUser)) {

            return $this->sendError(
                'Account not found'
            );
        }

        return $this->sendResponse(
            $accountUser,
            'Account retrieved successfully'
        );
    }

    public function agentCheckTransaction($id)
    {
        $transaction = Transaction::with('user')->where('code', $id)->first();

        if (empty($transaction)) {

            return $this->sendError(
                'Transaction not found'
            );
        }

        return $this->sendResponse(
            $transaction,
            'Transaction retrieved successfully'
        );
    }




















/**
     * Display a listing of the Account.
     * GET|HEAD /accounts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Account::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $accounts = $query->get();

        return $this->sendResponse(AccountResource::collection($accounts), 'Accounts retrieved successfully');
    }

    /**
     * Store a newly created Account in storage.
     * POST /accounts
     *
     * @param CreateAccountAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountAPIRequest $request)
    {
        $input = $request->all();

        /** @var Account $account */
        $input['user_id'] = Auth::id();
        $account = Account::create($input);

        return $this->sendResponse(new AccountResource($account), 'Account saved successfully');
    }

    /**
     * Display the specified Account.
     * GET|HEAD /accounts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Account $account */
        $account = Account::find($id);

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        return $this->sendResponse(new AccountResource($account), 'Account retrieved successfully');
    }

    /**
     * Update the specified Account in storage.
     * PUT/PATCH /accounts/{id}
     *
     * @param int $id
     * @param UpdateAccountAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountAPIRequest $request)
    {
        /** @var Account $account */
        $account = Account::find($id);

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        $account->fill($request->all());
        $account->save();

        return $this->sendResponse(new AccountResource($account), 'Account updated successfully');
    }

    /**
     * Remove the specified Account from storage.
     * DELETE /accounts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Account $account */
        $account = Account::find($id);

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        $account->delete();

        return $this->sendSuccess('Account deleted successfully');
    }
}
