<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;



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

            $transactionUrl = 'https://localhost:56232/Services/Transaction/Transaction/Create';
        
            // Send these cookies in the next request
            $transactionResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Cookie' => $cookies // Manually send the cookies here
                ])
                ->post($transactionUrl, [
                    "Entity" => [
                        "ClientId" => "1",
                        "TransactionType" => "2",
                        "Amount" => "1",
                        "ClientAccountNumber" => "",
                        "SenderPhone" => "",
                        "ClientFirstName" => "",
                        "ClientLastName" => ""
                    ]
                ]);
        
            if ($transactionResponse->successful()) {
                return $transactionResponse;
            } else {
                return response()->json(['error' => 'Transaction failed'], $transactionResponse->status());
            }
        } else {
            return response()->json(['error' => 'Authentication failed'], $loginResponse->status());
        }


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


        




        // $data = [
        //     'header' => [
        //         'property1' => 'value1',
        //         'property2' => 'value2',
        //         // More header properties here
        //     ],
        //     'firstname' => 'John',
        //     'lastname' => 'Doe',
        //     'middlename' => 'M',
        //     'dateOfBirth' => '1990-01-01',
        //     'identityType' => 'passport',
        //     'identityNo' => 'A12345678',
        //     'idIssueDate' => '2020-01-01',
        //     'idExpiryDate' => '2030-01-01',
        //     'bvn' => '12345678901',
        //     'mobileNo' => '08012345678',
        //     'email' => 'john.doe@example.com',
        //     'gender' => 'male',
        //     'address' => '123 Main St',
        //     'countryCode' => 'NG',
        //     'transactiontoken' => 'some-token',
        //     'id' => 'some-id'
        // ];
        // $response = Http::withOptions(['verify' => false])->post('https://localhost:56232/api/accounts/create', $data);


        // Amount:"2" // withdrawal
        // ClientAccountNumber:""
        // ClientFirstName:""
        // ClientId:"163"
        // ClientLastName: ""
        // SenderPhone:""
        // TransactionType:"2"

        // $data = [
        //     'header' => [
        //         'property1' => 'value1',
        //         'property2' => 'value2',
        //         // More header properties here
        //     ],
        //     'amount' => '1',
        //     'transactionType' => '1',
        //     'accountNumber' => '1441004741909',
        //     'transactionDate' => '2023-07-31',
        //     'transactionId' => 'TX1234567890'
        // ];
        // $response = Http::withOptions(['verify' => false])->post('https://localhost:56232/api/transactions/deposit', $data);


        // $data = [
        //     'header' => [
        //         'property1' => 'value1',
        //         'property2' => 'value2',
        //         // More header properties here
        //     ],
        //     'amount' => '1000',
        //     'transactionType' => 'withdrawal',
        //     'accountNumber' => '1234567890',
        //     'transactionDate' => '2023-07-28',
        //     'transactionId' => 'TX987654321'
        // ];
        // $response = Http::withOptions(['verify' => false])->post('https://localhost:56232/api/transactions/withdrawal', $data);



        // $accountReferenceNumber = '1441004730243';
        // $response = Http::withOptions(['verify' => false])->get("https://localhost:56232/api/accountnumbers/{$accountReferenceNumber}");

        return $response->body();
    } catch (RequestException $e) {
        return $e->getMessage();
    }
});


Route::get('/test-query', function () {
    try {

        // Base URI for the API
        $baseUri = 'https://localhost:56232';
        
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


// Route::get('/test-create-account', function () {
//     try {
//         $response = Http::post('http://localhost:56232/api/accounts/create', [
//             'header' => [ /* header data here */ ],
//             'firstname' => 'John',
//             'lastname' => 'Doe',
//             'middlename' => 'M',
//             'dateOfBirth' => '1990-01-01',
//             'identityType' => 'passport',
//             'identityNo' => 'A12345678',
//             'idIssueDate' => '2020-01-01',
//             'idExpiryDate' => '2030-01-01',
//             'bvn' => '12345678901',
//             'mobileNo' => '08012345678',
//             'email' => 'john.doe@example.com',
//             'gender' => 'male',
//             'address' => '123 Main St',
//             'countryCode' => 'NG',
//             'transactiontoken' => 'some-token',
//             'id' => 'some-id'
//         ]);

//         return $response->body();
//     } catch (RequestException $e) {
//         return $e->getMessage();
//     }
// });

// end to be removed




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
