<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AccountsController;

Route::post('/create-account', [AccountsController::class, 'createAccount']);



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


///login
Route::post('login', [App\Http\Controllers\API\UserAPIController::class, 'login'])->name('login');

Route::post('register', [App\Http\Controllers\API\UserAPIController::class, 'store'])->name('register');

Route::post('password/token', [App\Http\Controllers\API\ResetPasswordAPIController::class, 'createToken']);
Route::post('find/token', [App\Http\Controllers\API\ResetPasswordAPIController::class, 'find']);
Route::post('reset/password', [App\Http\Controllers\API\ResetPasswordAPIController::class, 'reset']);

Route::post('verify-card', [App\Http\Controllers\API\AccountAPIController::class, 'verifyCard']);


Route::post('login_pin', [App\Http\Controllers\API\PinAPIController::class, 'findPin']);
Route::post('reset_pin', [App\Http\Controllers\API\PinAPIController::class, 'store2']);

Route::post('contact_us', [App\Http\Controllers\API\UserAPIController::class, 'contactUs']); //n

Route::post('self_create', [App\Http\Controllers\API\UserAPIController::class, 'selfCreate']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('add_user', [App\Http\Controllers\API\UserAPIController::class, 'addUser']);
    Route::get('get_users', [App\Http\Controllers\API\UserAPIController::class, 'users']);
    Route::get('get_clients', [App\Http\Controllers\API\UserAPIController::class, 'clients']);
    Route::get('get_accounts', [App\Http\Controllers\API\AccountAPIController::class, 'accounts']);
    Route::get('get_transactions_admin', [App\Http\Controllers\API\AccountAPIController::class, 'adminTransactions']);
    Route::get('get_logs', [App\Http\Controllers\API\AccountAPIController::class, 'events']);

    Route::get('make_agent/{id}', [App\Http\Controllers\API\UserAPIController::class, 'agentStatus']);
    Route::get('agent_open_account/{id}', [App\Http\Controllers\API\AccountAPIController::class, 'openAccountAgent']);
    Route::post('agent_add_account', [App\Http\Controllers\API\AccountAPIController::class, 'addAccountAgent']);
    Route::post('new_transaction', [App\Http\Controllers\API\AccountAPIController::class, 'newTransaction']);

    Route::post('self_add_account', [App\Http\Controllers\API\AccountAPIController::class, 'addAccountSelf']);
    Route::get('self_create_account', [App\Http\Controllers\API\AccountAPIController::class, 'openAccount']);
    Route::get('self_create_code', [App\Http\Controllers\API\AccountAPIController::class, 'generatePayCode']);
    Route::get('self_transactions', [App\Http\Controllers\API\AccountAPIController::class, 'myTransactions']);
    Route::get('self_account', [App\Http\Controllers\API\AccountAPIController::class, 'myAccount']);




    Route::post('email_account', [App\Http\Controllers\API\AccountUserAPIController::class, 'emailAccount']);//n
    Route::post('make_agent', [App\Http\Controllers\API\UserAPIController::class, 'makeAgent']);//n
    Route::post('change_pin', [App\Http\Controllers\API\UserAPIController::class, 'changePin']);//n
    Route::post('change_password', [App\Http\Controllers\API\UserAPIController::class, 'changePass']);//n

    Route::post('enter_pin', [App\Http\Controllers\API\PinAPIController::class, 'findPin2']);
    Route::post('check_agent', [App\Http\Controllers\API\PinAPIController::class, 'checkAgent']);

    Route::post('transaction', [App\Http\Controllers\API\PaymentAPIController::class, 'store']);
    Route::post('self_transfer', [App\Http\Controllers\API\PaymentAPIController::class, 'wallet']);
    Route::post('create_account', [App\Http\Controllers\API\AccountUserAPIController::class, 'store']);
    Route::post('add_account', [App\Http\Controllers\API\AccountUserAPIController::class, 'addAccount']);
    Route::post('user_account', [App\Http\Controllers\API\PaymentAPIController::class, 'userAccount']);
    Route::post('get_account', [App\Http\Controllers\API\PaymentAPIController::class, 'account']);
    Route::post('get_code', [App\Http\Controllers\API\PaymentAPIController::class, 'generatePayCode']);
    Route::post('verify_code', [App\Http\Controllers\API\PaymentAPIController::class, 'verifyQRCode']);

    Route::post('get_transaction', [App\Http\Controllers\API\PaymentAPIController::class, 'userTransaction']);
    Route::get('get_transactions', [App\Http\Controllers\API\PaymentAPIController::class, 'transactions']);
    

    Route::get('/logout',[App\Http\Controllers\API\UserAPIController::class, 'logout'])->name('logout');
    Route::post('profile/update/{id}', [App\Http\Controllers\API\UserAPIController::class, 'updateProfile']);
    Route::post('password/update', [App\Http\Controllers\API\UserAPIController::class, 'changePassword']);

    Route::post('acct_user', [App\Http\Controllers\API\AccountUserAPIController::class, 'updateAcct']);

    Route::get('sync_data', [App\Http\Controllers\API\AccountUserAPIController::class, 'updateTrans']);

    Route::get('eco_accounts', [App\Http\Controllers\API\PaymentAPIController::class, 'accounts']);
    Route::get('eco_transactions', [App\Http\Controllers\API\PaymentAPIController::class, 'transactions']);
    Route::get('eco_account', [App\Http\Controllers\API\PaymentAPIController::class, 'account']);


    Route::post('users/update/{id}', [App\Http\Controllers\API\UserAPIController::class, 'update']);
    Route::post('contacts/update/{id}', [App\Http\Controllers\API\ContactAPIController::class, 'update']);
    Route::post('flags/update/{id}', [App\Http\Controllers\API\FlagAPIController::class, 'update']);
    Route::post('galleries/update/{id}', [App\Http\Controllers\API\GalleryAPIController::class, 'update']);
    Route::post('reset_passwords/update/{id}', [App\Http\Controllers\API\ResetPasswordAPIController::class, 'update']);




    Route::resource('users', App\Http\Controllers\API\UserAPIController::class);


    Route::resource('codes', App\Http\Controllers\API\CodeAPIController::class);


    Route::resource('cards', App\Http\Controllers\API\CardAPIController::class);


    Route::resource('accounts', App\Http\Controllers\API\AccountAPIController::class);


    Route::resource('account_users', App\Http\Controllers\API\AccountUserAPIController::class);


    Route::resource('card_users', App\Http\Controllers\API\CardUserAPIController::class);


    Route::resource('bins', App\Http\Controllers\API\BinAPIController::class);


    Route::resource('contacts', App\Http\Controllers\API\ContactAPIController::class);


    Route::resource('flags', App\Http\Controllers\API\FlagAPIController::class);


    Route::resource('galleries', App\Http\Controllers\API\GalleryAPIController::class);


    Route::resource('payments', App\Http\Controllers\API\PaymentAPIController::class);


    Route::resource('pins', App\Http\Controllers\API\PinAPIController::class);


    Route::resource('reset_passwords', App\Http\Controllers\API\ResetPasswordAPIController::class);


    Route::resource('settings', App\Http\Controllers\API\SettingAPIController::class);


    Route::resource('transactions', App\Http\Controllers\API\TransactionAPIController::class);


    Route::resource('user_settings', App\Http\Controllers\API\UserSettingAPIController::class);


    Route::resource('apps', App\Http\Controllers\API\AppAPIController::class);


    Route::resource('app_plans', App\Http\Controllers\API\AppPlanAPIController::class);


    Route::resource('app_plan_users', App\Http\Controllers\API\AppPlanUserAPIController::class);
    
});




Route::resource('logs', App\Http\Controllers\API\LogAPIController::class);


Route::resource('request_logs', App\Http\Controllers\API\RequestLogAPIController::class);
