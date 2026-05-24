<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;



use App\Services\EcobankPayloadService;
use App\Services\EcobankService;


Route::get('/test-validate-id', function (

    EcobankPayloadService $payloadService,

    EcobankService $ecobankService

) {

    $imagePath =
        storage_path(
            'app/public/test/test.jpg'
        );

    $base64Image =
        base64_encode(
            file_get_contents($imagePath)
        );

    $payload =
        $payloadService
            ->buildValidateIdentityPayload([

                'idNumber' =>
                    'GHA-717359825-1',

                'base64Image' =>
                    $base64Image,
            ]);

    return $ecobankService->post(
        'validateidentity',
        $payload
    );
});


Route::get('/test-account', function (
    EcobankPayloadService $payloadService,
    EcobankService $ecobankService
) {

    $payload =
        $payloadService->buildCreateAccountPayload([

            'firstname' => 'Jennifer',
            'lastname' => 'Ansuaa',
            'middlename' => null,

            'dateOfBirth' => '1998-05-28',

            'identityType' => 'GHANA_CARD',
            'identityNo' => 'GHA-712157296-2',

            'idIssueDate' => '2018-11-28',
            'idExpiryDate' => '2028-11-26',

            'bvn' => null,

            'mobileNo' => '233551759486',

            'email' => 'jennifer.ansuaa@gmail.com',

            'gender' => 'Female',

            'address' => 'Banana Street, Accra',

            'countryCode' => 'GH',

            // 'id' => 'CUS-' . rand(1000, 9999),
            'id' => 'CUPD0000000001900',
        ]);

    return $ecobankService->post(
        'createaccount',
        $payload
    );
});


Route::get('/test-get-account', function (
    EcobankPayloadService $payloadService,
    EcobankService $ecobankService
) {

    $payload =
        $payloadService->buildGetAccountPayload(
            '1441004826171'  // mine
            // '1441004738689'
            // 'CUPD0000000001900'
        );

    return $ecobankService->post(
        // 'getaccount',
        'getcustomerdetails',
        $payload
    );
});


Route::get('/test-deposit', function (
    EcobankPayloadService $payloadService,
    EcobankService $ecobankService
) {

    $payload =
        $payloadService->buildTransactionPayload([

            'amount' => '10',

            'senderaccount' => '1441004826171',

            'senderphone' => '233559148214',

            'thirdpartyphonenumber' => '233559148214',

            'narration' => 'Deposit Transaction',

            'sendername' => 'Jennifer Ansuaa',

            'transactiontype' => 'CASH_IN',
        ]);

    return $ecobankService->post(
        'cashin',
        $payload
    );
});


Route::get('/test-withdrawal', function (
    EcobankPayloadService $payloadService,
    EcobankService $ecobankService
) {

    $payload =
        $payloadService->buildTransactionPayload([

            'amount' => '10',

            'senderaccount' => '1441004826171',

            'senderphone' => '233551759486',

            'thirdpartyphonenumber' => '233551759486',

            'narration' => 'Withdrawal Transaction',

            'sendername' => 'Jennifer Ansuaa',

            'transactiontype' => 'CASH_OUT',
        ]);

    return $ecobankService->post(
        'cashout',
        $payload
    );
});






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// tobe removed 

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

Route::get('/test-create-account', function () {
    try {


        $loginUrl = 'https://localhost:56232/Account/Login';
        $loginResponse = Http::withOptions(['verify' => false])->post($loginUrl, [
            'Username' => 'admin',
            'Password' => 'serenity',
        ]);
        
        if ($loginResponse->successful()) {
            // Manually extract cookies from headers
            $cookies = $loginResponse->header('Set-Cookie');
        
            // Log the cookies to inspect
            Log::info('Set-Cookie Header: ' . $cookies);

            $clientUrl = 'https://localhost:56232/Services/Portofolio/Client/Create';
        
            // Send these cookies in the next request
            $clientResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Cookie' => $cookies // Manually send the cookies here
                ])
                ->post($clientUrl, [
                    "Entity" => [

                        "FirstName" => "Muhammed",
                        "LastName" => "Yakubu",
                        "MiddleName" => "",
                        "DateOfBirth" => "1997-04-11",
                        "Email" => "emjay.omananyi@gmail.com",
                        "PhoneNumber" => "0559148213",
                        "Gender" => "0",
                        "Address" => "Ayigya Zongo",
                        "CountryCode" => "0",
                        "IdentityType" => "0",
                        "IdentityNumber" => "GHA-12345-1",
                        "IdentityIssueDate" => "2024-08-06",
                        "IdentityExpiryDate" => "2024-08-31"
                    ]
                ]);
        
            if ($clientResponse->successful()) {
                return $clientResponse;
            } else {
                return response()->json(['error' => 'Regsteration failed'], $clientResponse->status());
            }
        } else {
            return response()->json(['error' => 'Authentication failed'], $loginResponse->status());
        }


        /////

        // $loginUrl = 'https://localhost:56232/Account/Login';
        // $loginResponse = Http::withOptions(['verify' => false])->post($loginUrl, [
        //     'Username' => 'admin',
        //     'Password' => 'serenity',
        // ]);
        
        // if ($loginResponse->successful()) {
        //     // Manually extract cookies from headers
        //     $cookies = $loginResponse->header('Set-Cookie');
        
        //     // Log the cookies to inspect
        //     Log::info('Set-Cookie Header: ' . $cookies);

        //     $transactionUrl = 'https://localhost:56232/Services/Transaction/Transaction/Create';
        
        //     // Send these cookies in the next request
        //     $transactionResponse = Http::withOptions(['verify' => false])
        //         ->withHeaders([
        //             'Cookie' => $cookies // Manually send the cookies here
        //         ])
        //         ->post($transactionUrl, [
        //             "Entity" => [
        //                 "ClientId" => "1",
        //                 // "ClientId" => "",
        //                 "TransactionType" => "1", // 2 withdrawal, 1 deposit
        //                 "Amount" => "1.00", //1
        //                 "ClientAccountNumber" => "",
        //                 // "ClientAccountNumber" => "CUPD0000000001899",
        //                 "SenderPhone" => "",
        //                 "ClientFirstName" => "",
        //                 "ClientLastName" => ""
        //             ]
        //         ]);
        
        //     if ($transactionResponse->successful()) {
        //         return $transactionResponse;
        //     } else {
        //         return response()->json(['error' => 'Transaction failed'], $transactionResponse->status());
        //     }
        // } else {
        //     return response()->json(['error' => 'Authentication failed'], $loginResponse->status());
        // }

        ///////
        

        ///////

        // $apiUrl = 'https://localhost:56232/Account/Login';
        // $response = Http::withOptions(['verify' => false])->post($apiUrl, [
        //     'Username' => "admin",
        //     'Password' => "serenity",
        // ]);

        // if ($response->successful()) {
        //     return $response;
        //     // return response()->json($response->json());
        // } else {
        //     return $response;
        //     // return response()->json(['error' => 'Authentication failed'], $response->status());
        // }


        return $response->body();
    } catch (RequestException $e) {
        return $e->getMessage();
    }
});


Route::get('/test-query', function () {
    try {

        // Base URI for the API
        $baseUri = 'https://localhost:56232';
        // $baseUri = 'https://sikafon.net:5001'; // live
        
        try {

            // client
            $response = Http::withOptions(['verify' => false])->get("$baseUri/api/getaccountnumber/from-database", [
                'identityType' => '0',
                'identityNumber' => 'GHA-004778177-3',
                'phoneNumber' => '0548330063'
            ]);
            
            if ($response->successful()) {
                $accountData = $response->json();
                // Process the data
                // dd($response);

                $data = $response->json();

                // Now you can safely access the data
                // if (isset($data["Id"])) {
                //     $id = $data["Id"];
                //     return $id;
                // } else {
                //     Log::error('Key "Id" not found in response', ['response' => $data]);
                // }
                return $response;
            } else {
                // Handle error
                $statusCode = $response->status();
                $error = $response->body();
                // Log error or return error response
                return $response;
            }


            // user
            // $apiUrl = 'https://localhost:56232/api/authenticate';
            // $response = Http::withOptions(['verify' => false])->post($apiUrl, [
            //     'Username' => "admin",
            //     'Password' => "serenity",
            // ]);
    
            // if ($response->successful()) {
            //     return $response;
            //     // return response()->json($response->json());
            // } else {
            //     return $response;
            //     // return response()->json(['error' => 'Authentication failed'], $response->status());
            // }


            // // transactions
            // $url = 'https://localhost:56232/api/transactions/by-client-id';

            // $response = Http::withOptions(['verify' => false])->get($url, [
            //     'clientId' => 10
            // ]);
            
            // if ($response->successful()) {
            //     return $response;
            //     // return $response->json();
            // } else {
            //     return $response;
            //     // return response()->json(['error' => 'Unable to fetch transactions'], $response->status());
            // }

            // transactions
            // $data = [
            //     'ClientId' => 30,
            //     'Amount' => '1', // 1 withdrawal, 2 deposit
            //     'SenderAccount' => '1441004748208',
            //     'SenderPhone' => '233548282980',
            //     'SenderName' => 'Acheampong Millicent',
            //     'TransactionType' => 2
            // ];
            // $response = Http::withOptions(['verify' => false])->post('https://localhost:56232/api/transactions/save', $data);

            // return $response;


            // create account
            $data = [
                'FirstName' => 'Muhammed',
                'LastName' => 'Jamiu',
                'MiddleName' => '',
                'DateOfBirth' => '1990-01-01',
                'Email' => 'emjaya@gmail.com',
                'PhoneNumber' => '0559148214',
                'Gender' => '0', // 1 or 0
                'Address' => '123 Main St',
                'CountryCode' => '0', // 0 
                'IdentityType' => '0',
                'IdentityNumber' => 'GH-1234567-2',
                'IdentityIssueDate' => '2010-01-01',
                'IdentityExpiryDate' => '2030-01-01',
                'UserId' => 1,
                'AccountNumber' => ''
            ];
            $response = Http::withOptions(['verify' => false])->post('https://localhost:56232/api/client/create', $data);

            return $response;


            

        } catch (RequestException $e) {
            echo $e->response->getBody()->getContents();
        }
    } catch (RequestException $e) {
        return $e->getMessage();
    }
});


Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    // Artisan::call('migrate');
    
 
    return "Cleared!";
 
});
Route::get('/test', function () {
    return view('index');
});

// Route::get('{any}', [PageController::class, 'index'])->where('any','.*');
