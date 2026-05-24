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
use App\Models\Transaction;
use App\Models\AccountUser;
use App\Models\CardUser;

use App\Services\BankingService;

/**
 * Class PaymentController
 * @package App\Http\Controllers\API
 */

class PaymentAPIController extends AppBaseController
{

    protected $bankingService;

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
    public function store(CreatePaymentAPIRequest $request)
    {
        $input = $request->all();

        try {
            DB::beginTransaction();

            $receiveCharge = Helpers::getFlagValue('receive-trans-charge')?? 1;
            $sendCharge = Helpers::getFlagValue('send-trans-charge')?? 1;
            $transCharge = Helpers::getFlagValue('trans-charge')?? 1;
            $eCharge = Helpers::getFlagValue('e-charge')?? 0.04;

            $aRC = 0;
            $aSC = 0;
            $aTC = 0;
            $aEC = 0;

            $receiveChargeCon = Helpers::getFlagValue('receive-trans-charge-con')?? 0;
            if ($request->amount > $receiveChargeCon) {
                $aRC = ($receiveCharge/100)*$amount;
            }
            $sendChargeCon = Helpers::getFlagValue('send-trans-charge-con')?? 0;
            if ($request->amount > $sendChargeCon) {
                $aSC = ($sendCharge/100)*$amount;
            }
            $transChargeCon = Helpers::getFlagValue('trans-charge-con')?? 0;
            if ($request->amount > $transChargeCon) {
                $aTC = ($transCharge/100)*$amount;
            }
            $eChargeCon = Helpers::getFlagValue('e-charge-con')?? 100;
            if ($request->amount > $eChargeCon) {
                $aEC = ($eCharge/100)*$amount;
            }


            

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

            $editCode->codeable_id = $payment->id;
            $editCode->update();

            $transaction = new Transaction();
            $transaction->user_id = Auth::id();
            $transaction->code = Helpers::generateVerificationCode();
            $transaction->amount = $request->amount;
            $transaction->payment_id = $payment->id;
            $transaction->save();

            switch ($request->trans_type) {
                case '1': // load
                    // from to sikafon
                    $fromAccountUser = AccountUser::where('user_id', $request->fromId)->first();
                    if (empty($fromAccountUser)) {
                        return $this->sendSuccess('Sender not found');
                    }

                    $take = Helpers::takeMoney($amount, $cardId); // from into sikafon acct

                    $acct = Helpers::getTransaction(Auth::id(), $transaction->id);
                    if ($acct['status'] == true) {
                        $fromAccountUser->balance += $amount;
                        $fromAccountUser->update();

                        $transaction1 = Transaction::find($transaction->id);
                        if (empty($transaction1)) {

                        }
                        $transaction1->status = 5;
                        $transaction1->update();
                        
                    }

                    
                    break;
                case '2': // pay
                    // sikafon to sikafon
                    $fromAccountUser = AccountUser::where('user_id', $request->fromId)->first();
                    if (empty($fromAccountUser)) {
                        return $this->sendSuccess('Sender not found');
                    }

                    $toAccountUser = AccountUser::where('user_id', $request->toId)->first();
                    if (empty($toAccountUser)) {
                        return $this->sendSuccess('Receiver not found');
                    }

                    $take = Helpers::takeMoney($amount, $cardId); 
                    $pay = Helpers::putMoney($amount-($aTC+$aEC), $cardId); // finally to receiver's acct

                    $acct = Helpers::getTransaction(Auth::id(), $transaction->id);
                    if ($acct['status'] == true) {
                        $toAccountUser->balance += $amount-($aTC+$aEC);
                        $toAccountUser->update();
                        $fromAccountUser->balance -= $amount;
                        $fromAccountUser->update();

                        $transaction1 = Transaction::find($transaction->id);
                        if (empty($transaction1)) {

                        }
                        $transaction1->status = 5;
                        $transaction1->update();
                        
                    }
                    
                    break;
                case '3': // transfer
                    // sikafon to sikafon
                    $fromAccountUser = AccountUser::where('user_id', $request->fromId)->first();
                    if (empty($fromAccountUser)) {
                        return $this->sendSuccess('Sender not found');
                    }

                    $toAccountUser = AccountUser::where('user_id', $request->toId)->first();
                    if (empty($toAccountUser)) {
                        return $this->sendSuccess('Receiver not found');
                    }
                    
                    $pay = Helpers::putMoney($amount-($aTC+$aEC+$aSC), $cardId); // from sikafon to the receiver's acct

                    $acct = Helpers::getTransaction(Auth::id(), $transaction->id);
                    if ($acct['status'] == true) {
                        $toAccountUser->balance += $aTC+$aEC+$aSC;
                        $toAccountUser->update();
                        $fromAccountUser->balance -= $amount;
                        $fromAccountUser->update();

                        $transaction1 = Transaction::find($transaction->id);
                        if (empty($transaction1)) {

                        }
                        $transaction1->status = 5;
                        $transaction1->update();
                        
                    }
                    
                    break;
                case '4': // receive
                    // sikafon to sikafon
                    $fromAccountUser = AccountUser::where('user_id', $request->fromId)->first();
                    if (empty($fromAccountUser)) {
                        return $this->sendSuccess('Sender not found');
                    }

                    $toAccountUser = AccountUser::where('user_id', $request->toId)->first();
                    if (empty($toAccountUser)) {
                        return $this->sendSuccess('Receiver not found');
                    }

                    $take = Helpers::takeMoney($amount, $cardId); // from into sikafon acct
                    $pay = Helpers::putMoney($amount-($aTC+$aEC), $cardId); // finally to receiver's acct

                    $acct = Helpers::getTransaction(Auth::id(), $transaction->id);
                    if ($acct['status'] == true) {
                        $toAccountUser->balance += $aTC+$aEC;
                        $toAccountUser->update();
                        $fromAccountUser->balance -= $amount;
                        $fromAccountUser->update();

                        $transaction1 = Transaction::find($transaction->id);
                        if (empty($transaction1)) {

                        }
                        $transaction1->status = 5;
                        $transaction1->update();
                        
                    }
                    
                    break;
                case '5': // cashout
                    // sikafon to account
                    $fromAccountUser = AccountUser::where('user_id', $request->fromId)->first();
                    if (empty($fromAccountUser)) {
                        return $this->sendSuccess('Sender not found');
                    }

                    $pay = Helpers::putMoney($amount-($aTC+$aEC), $cardId); // from sikafon to the user's acct

                    $acct = Helpers::getTransaction(Auth::id(), $transaction->id);
                    if ($acct['status'] == true) {
                        $fromAccountUser->balance -= $amount;
                        $fromAccountUser->update();

                        $transaction1 = Transaction::find($transaction->id);
                        if (empty($transaction1)) {

                        }
                        $transaction1->status = 5;
                        $transaction1->update();
                        
                    }
                    
                    break;
                default:
                    return;
                    break;
            }

            DB::commit();

            return $this->sendResponse(new PaymentResource($payment), 'Payment saved successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->sendError($ex->getMessage());
        }
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

    public function account(Request $request)
    {
        /** @var Payment $payment */
        $account = UserAccount::where('user_id', Auth::id())->first();

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        $getAccount = Helpers::getAccount($account->id, $status);

        return $this->sendResponse($getAccount, 'Account retrieved successfully');
    }

    public function accounts(Request $request)
    {
        /** @var Payment $payment */
        $accounts = Helpers::getAccounts();

        return $this->sendResponse($accounts, 'Accounts retrieved successfully');
    }

    public function transactions(Request $request)
    {
        /** @var Payment $payment */
        $account = UserAccount::where('user_id', Auth::id())->first();

        if (empty($account)) {
            return $this->sendError('Account not found');
        }

        $transactions = Helpers::getTransactions($userId, $status);

        return $this->sendResponse($transactions, 'Transactions retrieved successfully');
    }


    public function generatePayCode (Request $request)
    {
        $code = Helpers::generateVerificationCode();
        $qrCodeResult = Helpers::generateAndDecodeQRCode($code);
        if (!$qrCodeResult['success']) {
            return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
        }

        $currentDateTime = Carbon::now();
        $expirationDateTime = $currentDateTime->addMinutes(2);

        $code = new Code();
        $code->user_id = Auth::id();
        $code->code = $code;
        $code->url = $qrCodeResult['file_path'];
        $code->codeable_type = 'App\Models\Payment';
        $code->expired_at = $expirationDateTime;
        // $code->codeable_id = $data->id;
        $code->save();

        return $this->sendResponse($code, 'Account retrieved successfully');
    }

    
}
