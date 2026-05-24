<?php

namespace App\Helper;

use App\Models\AllFile;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;
use App\Models\File;
use App\Models\User;
use App\Models\AccountUser;
use App\Models\Flag;

use Illuminate\Support\Str;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;

use Zxing\QrReader;

class Helpers {

    //get accounts
    public static function getAccounts()
    {
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer your-token',
        // ])->get('https://server-api-url/api/endpoint');

        $response = Http::get('https://server-api-url/api/endpoint');

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json(); // Extract JSON response
            // Process $data as needed
        } else {
            // Handle the error
            $statusCode = $response->status();
            // Handle the error based on $statusCode
        }

        return $response;
    }

    // get an account
    public static function getAccount($userId, $status)
    {
        // Set up the base URL and endpoint
        $baseUrl = 'https://server-api-url/api/endpoint';

        // Set up the headers
        $headers = [
            'Authorization' => 'Bearer your-token',
        ];

        // Make the GET request with query parameters
        $response = Http::withHeaders($headers)->get($baseUrl, [
            'userid' => $userId,
            'status' => $status,
        ]);

        // $response = Http::get($baseUrl, [
        //     'userid' => $userid,
        //     'status' => $status,
        // ]);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            // Process $data as needed
            return $data;
        } else {
            // Handle the error
            $statusCode = $response->status();
            // Handle the error based on $statusCode
            return ['error' => 'Request failed', 'status' => $statusCode];
        }
    }

    // get all transactions for an account
    public static function getTransactions($userId, $status)
    {
        // Set up the base URL and endpoint
        $baseUrl = 'https://server-api-url/api/endpoint';

        // Set up the headers
        $headers = [
            'Authorization' => 'Bearer your-token',
        ];

        // Make the GET request with query parameters
        $response = Http::withHeaders($headers)->get($baseUrl, [
            'userid' => $userId,
            'status' => $status,
        ]);

        // $response = Http::get($baseUrl, [
        //     'userid' => $userid,
        //     'status' => $status,
        // ]);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            // Process $data as needed
            return $data;
        } else {
            // Handle the error
            $statusCode = $response->status();
            // Handle the error based on $statusCode
            return ['error' => 'Request failed', 'status' => $statusCode];
        }
    }

    // get a transaction
    public static function getTransaction($userId, $transId)
    {
        // Set up the base URL and endpoint
        $baseUrl = 'https://server-api-url/api/endpoint';

        // Set up the headers
        $headers = [
            'Authorization' => 'Bearer your-token',
        ];

        // Make the GET request with query parameters
        $response = Http::withHeaders($headers)->get($baseUrl, [
            'userid' => $userid,
            'trans_id' => $transId,
        ]);

        // $response = Http::get($baseUrl, [
        //     'userid' => $userid,
        //     'trans_id' => $transId,
        // ]);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            // Process $data as needed
            return $data;
        } else {
            // Handle the error
            $statusCode = $response->status();
            // Handle the error based on $statusCode
            return ['error' => 'Request failed', 'status' => $statusCode];
        }
    }

    // verify ID
    public static function verifyId($cardId, $cardType)
    {
        return [
            'success' => true,
            'cardInfo' => [
                'first_name' => 'Muhammed-Jamiu',
                'last_name'  => 'Yakubu',
                'phone'      => '0557522685',
                'email'      => 'yakubumuhammedjaamiu@gmail.com',
                'dob'      => '11-04-1997',
                'country'      => 'Ghana',
                'address'      => '20AZ Ayigya zongo',
                'state'      => 'Ashanti',
                'city'      => 'Kumasi',
                'issued' => '08-05-2022',
                'expired' => '08-05-2030',

            ]
        ];
        // Set up the base URL and endpoint
        $baseUrl = 'https://server-api-url/api/endpoint';

        // Set up the headers
        $headers = [
            'Authorization' => 'Bearer your-token',
        ];

        // Make the GET request with query parameters
        $response = Http::withHeaders($headers)->get($baseUrl, [
            'card_id' => $cardId,
            'card_type' => $cardType,
        ]);

        // $response = Http::get($baseUrl, [
        //     'card_id' => $cardId,
        //     'card_type' => $cardType,
        // ]);

        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            // Process $data as needed
            return $data;
        } else {
            // Handle the error
            $statusCode = $response->status();
            // Handle the error based on $statusCode
            return ['error' => 'Request failed', 'status' => $statusCode];
        }
    }

    // put money into an account
    public static function putMoney($amount, $cardId)
    {
        try {

            // if(auth()->user()) {
            //     $name = auth()->user()->first_name
            // }

            $acct = AccountUser::find($cardId);
            if (empty($acct)) {
                return 'card not found';
            }

            $user = User::find($acct->id);
            if (empty($user)) {
                return 'User not found';
            }

            if ($user->middle_name) {
                $name = $user->last_name.' '.$user->middle_name.' '.$user->first_name;
            } else {
                $name = $user->last_name.' '.$user->first_name;
            }

            // Data to be sent in the POST request
            $dataToSend = [
                "amount" => $amount,
                "name" => $name,
                "phone" => $user->phone,
                "account_id" => $acct->id,
                "transaction_type" => 1, // take
            ];

            // Define the headers
            $headers = [
                'Authorization' => 'Bearer your-token',
                'Content-Type' => 'application/json',
            ];

            // Make the POST request with headers
            $response = Http::withHeaders($headers)->post('https://nana-frimpomaa.com/api/sync_db', $dataToSend);

            // $response = Http::post('https://nana-frimpomaa.com/api/sync_db', $dataToSend);

            if ($response->successful()) {
                $responseData = json_decode($response->body(), true);
                $responseData = $responseData['data'];

                if (!empty($responseData)) {
                    if (!empty($responseData['messages'])) {
                        // Handle messages in the response
                    }
                }

                return $responseData;
            } else {
                $statusCode = $response->status();
                \Log::info($statusCode);
                return $statusCode;
            }
        } catch (\Exception $ex) {
            \Log::info($ex);
            return $ex->getMessage();
        }
    }

    // take money from an account
    public static function takeMoney($amount, $cardId)
    {
        try {
            $acct = AccountUser::find($cardId);
            if (empty($acct)) {
                return 'card not found';
            }

            $user = User::find($acct->id);
            if (empty($user)) {
                return 'User not found';
            }

            if ($user->middle_name) {
                $name = $user->last_name.' '.$user->middle_name.' '.$user->first_name;
            } else {
                $name = $user->last_name.' '.$user->first_name;
            }

            // Data to be sent in the POST request
            $dataToSend = [
                "amount" => $amount,
                "name" => $name,
                "phone" => $user->phone,
                "account_id" => $acct->id,
                "transaction_type" => 2, // take
            ];

            // Define the headers
            $headers = [
                'Authorization' => 'Bearer your-token',
                'Content-Type' => 'application/json',
            ];

            // Make the POST request with headers
            $response = Http::withHeaders($headers)->post('https://nana-frimpomaa.com/api/sync_db', $dataToSend);

            // $response = Http::post('https://nana-frimpomaa.com/api/sync_db', $dataToSend);

            if ($response->successful()) {
                $responseData = json_decode($response->body(), true);
                $responseData = $responseData['data'];

                if (!empty($responseData)) {
                    if (!empty($responseData['messages'])) {
                        // Handle messages in the response
                    }
                }

                return $responseData;
            } else {
                $statusCode = $response->status();
                \Log::info($statusCode);
                return $statusCode;
            }
        } catch (\Exception $ex) {
            \Log::info($ex);
            return $ex->getMessage();
        }
    }


    // get an account
    public static function completeTrans($amount)
    {
        $complete = AccountUser::find(Flag::APIACCOUNT);
        if (!empty($complete)) {
            $complete->balance = $complete->balance + $amount;
            $complete->update();
        }
    }


    // composer require endroid/qr-code
    // composer require khanamiryan/qrcode-detector-decoder

    public static function createQRCode($data, $path) {
        $result = Builder::create()
            ->data($data)
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->build();

        $result->saveToFile($path);
    }

    public static function createQRCode1($data, $filename)
    {
        try {
            // Ensure the directory exists
            $directory = 'public/codes';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Set the file path
            $filePath = $directory . '/' . $filename;

            // Create a QR code with the given data
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($data)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                ->build();

            // Save the QR code to the specified file path
            Storage::put($filePath, $result->getString());

            return ['success' => true, 'file_path' => Storage::url($filePath)];
        } catch (\Exception $ex) {
            \Log::error($ex);
            return ['success' => false, 'error' => $ex->getMessage()];
        }
    }

    public static function decodeQRCode($filename)
    {
        try {
            // Set the file path
            $filePath = storage_path('app/public/codes/' . $filename);

            // Check if the file exists
            if (!file_exists($filePath)) {
                return ['success' => false, 'error' => 'File not found'];
            }

            // Read the QR code from the specified file path
            $qrcode = new QrReader($filePath);
            $text = $qrcode->text(); // Return decoded text from QR code

            if ($text !== false) {
                return ['success' => true, 'data' => $text];
            } else {
                return ['success' => false, 'error' => 'Failed to decode QR code'];
            }
        } catch (\Exception $ex) {
            \Log::error($ex);
            return ['success' => false, 'error' => $ex->getMessage()];
        }
    }

    public static function generateAndDecodeQRCode($data)
    {
        // Define the filename to save the QR code
        $filename = 'qr-code-' . time() . '.png';

        // Create QR Code
        $createResult = self::createQRCode($data, $filename);
        if ($createResult['success']) {
            echo "QR Code created at: " . $createResult['file_path'] . "\n";

            // return $createResult['file_path'];

            // Decode QR Code
            $decodeResult = self::decodeQRCode($filename);
            if ($decodeResult['success']) {
                echo "Decoded data from QR Code: " . $decodeResult['data'] . "\n";
            } else {
                echo "Failed to decode QR Code: " . $decodeResult['error'] . "\n";
            }
        } else {
            return '';
            echo "Failed to create QR Code: " . $createResult['error'] . "\n";
        }
    }







    public static function postReq($data)
    {
        try {

            $dataToSend = [
                "applications" => $applications,
                "messages" => $messages,
                "cards" => $cards,
                "registers" => $registers,
                "schedules" => $schedules,
            ];
            
            $response = Http::post('https://nana-frimpomaa.com/api/sync_db', $dataToSend);
            
            if ($response->successful()) {
                // $responseData = $response->json(); // Response from the server
                $responseData = json_decode($response->body(), true);
                $responseData = $responseData['data'];
                // \Log::info($responseData);
                if (!empty($responseData)) {
                    if (!empty($responseData['messages'])) {
                        // $responseData['cards']
                    }
                    
                }
                // return json_decode($response->body(), true);
                return $responseData;
            } else {
                $statusCode = $response->status();
                \Log::info($statusCode);
                return $statusCode;
            }

        } catch (\Exception $ex) {
            \Log::info($ex);
            return $ex->getMessage();
        }
    }



    public static function getIntContact($num, $country)
    {
        $countryCode = self::getCountryData($country)['callingCode'];
        return preg_replace('/^(?:\+?'.$countryCode.'|0)?/', $countryCode, $num);
        // return preg_replace('/^(?:\+?27|0)?/','+27', $num);

        // echo getIntContact("797734809", $countryCode) . "\n";
        // echo getIntContact("0797734809", $countryCode) . "\n";
        // echo getIntContact("23397734809", $countryCode) . "\n";
        // echo getIntContact("+23397734809", $countryCode);

        // +23397734809
    }

    public static function getCountryData($country) 
    {
        //https://github.com/antonioribeiro/countries
        $countries = new Countries();

        // $all = $countries->all();
        // return $all;

        // return $countries->toJson();
        // $countries->all()->pluck('name.common')->toArray();
        // $countries->all()->pluck('currencies')->toArray();


        // $unitedStatesFlag = 
        //     // $countries->where('name.common', 'Ghana')
        //     // $countries->where('cca3', 'GHA')
        //     $countries->where('cca2', 'GH')
        //     ->first()
        //     ->flag
        //     ->flag_icon;
        // return $unitedStatesFlag;
        // return $countries->where('name.common', 'Ghana')
        //     ->first()
        //     ->hydrateStates()
        //     ->states
        //     // ->sortBy('name')
        //     // ->pluck('name', 'postal', 'cities')
        //     ;

        // return $countries->where('name.common', 'Ghana')->first()->currencies; //["GHS"]
        // return $countries->where('name.common', 'Ghana')->first()->name;
        // return $countries->where('name.common', 'Ghana')->first()->postal; //GH
        // return $countries->where('name.common', 'Ghana')->first()->hydrateStates();
        // $countries->currencies();

        // $country = 'Ghana';
        // $country = ucwords($country);
        $countryD = $countries->where('name.common', $country)->first()->hydrateStates();
        $countryCode = $countryD->calling_codes[0];
        $countryFlag = $countryD->flag['flag-icon'];//"<span class=\"flag-icon flag-icon-gh\"></span>"
        // $countryCurrency = $countries->where('name.common', 'Ghana')->first()->currencies[0];

        // echo $countryFlag;
        // echo $countryCode;
        return [
            "callingCode"=> $countryCode,
            "flag"=> $countryFlag,
        ];
    }

    public static function userTypeName()
    {
        $role = '';
        if(auth()->user()) {
            if(auth()->user()->status  == 0) {
                $role = 'user';
            } else if(auth()->user()->status  == 1) {
                $role = 'super';
            } else if(auth()->user()->status  == 2) {
                $role = 'admin';
            } else if(auth()->user()->status  == 3) {
                $role = 'agent';
            } else if(auth()->user()->status  == 4) {

            }
        }

        return $role;
    }

    /**
     * Get role id
    */
    public static function getRoleID($roleName)
    {
        $role = Role::where('name', $roleName)->select('id')->first();
        return $role->id;
    }

    /**
     * Get flags parameter @param String $flagName
     * */
    public static function getFlagValue(string $flagName)
    {
        return Flag::where('name', $flagName)->where('status', true)->value('value');
    }

    // save any file to storage path
    public static function getFileUrl($request, $file, $directory)
    {
        $url = "";

        if($request->hasFile($file)){
            $myFile  = $request->file($file);

            $extension = $myFile->getClientOriginalExtension();
            $mimeType = $myFile->getClientMimeType();
            $filename  = time() . Str::random(5) . '.' . $extension;
            $url = 'storage/'.$directory . '/'. $filename;

            $imageFiles = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
            if (in_array($extension, $imageFiles)) {
                
    
                $img      = Image::make($myFile->getRealPath());
                $img->resize(300, 300, function ($ratio) {
                    $ratio->aspectRatio();
                });

                $img->stream();
                Storage::put('public/'.$directory . '/'. $filename, $img);
                
            } else {
                // Storage::put('public/'.$directory . '/'. $filename, $myFile);
                $myFile->storeAs('public/'.$directory . '/', $filename);
            }
        }
        return $url;
    }

    // acronyms of words
    public static function getAcronyms($word)
    {
        $words = preg_split("/[\s,_-]+/", $word);
        $acronym = "";
        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        return strtoupper('SF-' . $acronym);
    }

    // save image to laravel storage
    public static function getImageUrlFromStorage($request, $file, $directory)
    {
        // return $request;
        
        $url = "";
        if($request->hasFile($file)){
            $picture  = $request->file($file);
            $extension = $picture->getClientOriginalExtension();
            $filename  = time() . Str::random(5) . '.' . $extension;
            // $filename = time().$picture->getClientOriginalName();
            $img      = Image::make($picture->getRealPath());
            $img->resize(300, 300, function ($ratio) {
                $ratio->aspectRatio();
            });

            $img->stream();

            Storage::put('public/'.$directory.'/'.$filename, $img);

            $url =  'storage/'.$directory.'/'.$filename;
        }
        return $url;
    }

    /**
     * Generate random password
     *
     * @param string $string
     * @param int $length
     * @return string
     */
    public static function generatePassword(string $string="abcdefghijklmnopqrstuvwxyz1234567890", int $length=6): string
    {
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $string[rand(0, strlen($string) - 1)];
        }

        return env('APP_ENV') == 'local' ? "secret" : $password;
    }

    /**
     * Random verification code generation
     * Code mostly used to enable password change
     * */
    public static function generateVerificationCode(): string
    {
        return rand(100000, 999999);
    }

    // string of specified length
    public static function randomStrings($length = 9): string
    {
        return substr(md5(time()), 0, $length);
    }

    // send sms for job
    public static function sendSMS($to, $message): array
    {
        try {
            $url = 'https://api.mnotify.com/api/sms/quick?key='.config('services.m_notify.api_key');
            $data = [
                'recipient' => explode(',', $to),
                'sender' => config('services.m_notify.sender_id'),
                'message' => $message,
                'is_schedule' => 'false',
                'schedule_date' => ''
            ];

            $response = Http::post($url, $data)->json();

            logger($response);

            return $response;
        } catch (\Exception $e) {
            logger("error sending sms: " . $e->getMessage());

            return [];
        }
    }

}
