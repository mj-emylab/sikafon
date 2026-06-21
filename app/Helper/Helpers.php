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

use App\Models\CardUser;

use Illuminate\Support\Str;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

use Zxing\QrReader; // Add this for decoding

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class Helpers {


    public static function sendSMS($recipients, $message)
    {
        $senderId= "Sikafon GH";

        \Log::info($message.' ----- '.$senderId);

        // Split the recipients into an array and trim spaces
        $recipientArray = array_map('trim', explode(',', $recipients));

        // Convert local numbers to international format if needed
        foreach ($recipientArray as &$recipient) {
            if (preg_match('/^0[0-9]{9}$/', $recipient)) {
                // Assume a local number (e.g., 024113234) and convert to international (23324113234)
                $recipient = '233' . substr($recipient, 1);
            }
        }

        // Join the formatted numbers back into a comma-separated string
        $formattedRecipients = implode(',', $recipientArray);

        // $messageDb = new Message();
        // $messageDb->body = $message;
        // $messageDb->phone =  $formattedRecipients;
        // $messageDb->type = 3;
        // $messageDb->save();

        try {
            $url = "https://sms.nalosolutions.com/smsbackend/Resl_Nalo/send-message/";

            $response = Http::post($url, [
                'key'       => 'z@iyo3k9hnf5(!21887f#kl(k5vt8odot(wa_fl@komn86w7phh0!ozarghf8ebo',
                'msisdn'    => $formattedRecipients,  // Change the number here as needed
                'message'   => $message,
                'sender_id' => $senderId
            ]);

            // Log the response
            \Log::info($response);

            return $response;
        } catch (\Exception $e) {
            // Log any errors
            \Log::info("Error sending SMS: " . $e->getMessage());

            // Return an error response
            return ["error" => $e->getMessage()];
        }
    }

    public static function sendSMS2($recipients, $message)
    {
        $senderId= "Frimpomaa";

        \Log::info($message.' ----- '.$senderId);

        // Split the recipients into an array and trim spaces
        $recipientArray = array_map('trim', explode(',', $recipients));

        // Convert local numbers to international format if needed
        foreach ($recipientArray as &$recipient) {
            if (preg_match('/^0[0-9]{9}$/', $recipient)) {
                // Assume a local number (e.g., 024113234) and convert to international (23324113234)
                $recipient = '233' . substr($recipient, 1);
            }
        }

        // Join the formatted numbers back into a comma-separated string
        $formattedRecipients = implode(',', $recipientArray);

        // $messageDb = new Message();
        // $messageDb->body = $message;
        // $messageDb->phone =  $formattedRecipients;
        // $messageDb->type = 3;
        // $messageDb->save();

        try {
            $url = "https://sms.arkesel.com/sms/api?action=send-sms";

            $response = Http::get($url, [
                'action'=> 'send-sms',
                'api_key' => 'Snhxd29EUkNwT1pLRlJRZXNMVUM',
                'to' => $formattedRecipients,
                'from' => 'Frimpomaa',
                // 'from' => 'Vote CPP #7',
                "sms" => $message,
            ]);

            // Log the response
            \Log::info($response);

            return $response;
        } catch (\Exception $e) {
            // Log any errors
            \Log::info("Error sending SMS: " . $e->getMessage());

            // Return an error response
            return ["error" => $e->getMessage()];
        }
    }





    public static function encryptVoiceData(
        string $plainText,
        string $voiceCode
    ): string {

        $key = hash('sha256', $voiceCode, true);

        $iv = random_bytes(16);

        $encrypted = openssl_encrypt(
            $plainText,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return base64_encode(
            $iv . $encrypted
        );
    }

    public static function decryptVoiceData(
        string $cipherText,
        string $voiceCode
    ): ?string {

        try {

            $data = base64_decode($cipherText);

            $iv = substr($data, 0, 16);

            $encrypted = substr($data, 16);

            $key = hash('sha256', $voiceCode, true);

            $decrypted = openssl_decrypt(
                $encrypted,
                'AES-256-CBC',
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            return $decrypted ?: null;

        } catch (\Throwable $e) {

            return null;
        }
    }

    
    public static function verifyCard(
        $firstName,
        $lastName,
        $cardId
    ) {

        $cardUser = CardUser::where('card_no', $cardId)
            ->first();

        if (!$cardUser) {

            return [
                'success' => false,
                'message' => 'Card not found'
            ];
        }

        if (
            strtolower(trim($cardUser->first_name)) !== strtolower(trim($firstName)) ||
            strtolower(trim($cardUser->last_name)) !== strtolower(trim($lastName))
        ) {

            return [
                'success' => false,
                'message' => 'Card details do not match'
            ];
        }

        return [
            'success' => true,
            'message' => 'Card verified successfully',
            'user' => $cardUser
        ];
    }


    public static function createQRCode($data, $filename) {
        // Define the path to save the QR code
        $path = storage_path('app/public/codes/' . $filename);

        // Ensure the directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        // $logoPath = public_path('assets/img/d.jpg');
        $logoPath = public_path('assets/img/logo.png');

        // Build the QR code
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            // ->data('Custom QR code contents')
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            // ->logoPath(__DIR__.'/assets/symfony.png')
            ->logoPath($logoPath) // Add the logo
            ->logoResizeToWidth(50)
            ->logoPunchoutBackground(true)
            ->labelText('SIKAFON')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(LabelAlignment::Center)
            ->validateResult(false)
            ->build();

        // Save the QR code to the specified path
        $result->saveToFile($path);
    }

    public static function decodeQRCode1($fileName) {
        // Extract the filename from the full path
        $fileName = basename($fileName);

        $filePath = storage_path('app/public/codes/' . $filename);
        
        if (!file_exists($filePath)) {
            throw new Exception('QR code file does not exist.');
        }

        $qrcode = new QrReader($filePath);
        // Decode the QR code
        $text = $qrcode->text(); 
    
        // Return the decoded text
        return $text;
    }

    public static function decodeQRCode($fileName) {
        // Extract the filename from the full path
        $fileName = basename($fileName);

        $filePath = storage_path('app/public/scanned_codes/' . $fileName);
        
        if (!file_exists($filePath)) {
            throw new Exception('QR code file does not exist.');
        }

        $qrcode = new QrReader($filePath);
        // Decode the QR code
        $text = $qrcode->text(); 
    
        // Return the decoded text
        return $text;
    }

    public static function generateQRCode($data) {
        // Define the filename for the QR code
        $filename = 'qr-code-' . uniqid() . '.png';
    
        try {
            // Create the QR code
            self::createQRCode($data, $filename);
    
            // Return success and file path
            return [
                'success' => true,
                'file_path' => storage_path('app/public/codes/' . $filename)
            ];
        } catch (Exception $e) {
            // Return error details
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public static function generateAndDecodeQRCode($data) {
        // Define the filename for the QR code
        $filename = 'qr-code-' . uniqid() . '.png';
        $filePath = storage_path('app/public/codes/' . $filename);

        $logoPath = public_path('assets/img/d.jpg');
    
        try {
            // Generate the QR code
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                // ->data('Custom QR code contents')
                ->data($data)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                // ->logoPath(__DIR__.'/assets/symfony.png')
                ->logoPath($logoPath) // Add the logo
                ->logoResizeToWidth(50)
                ->logoPunchoutBackground(true)
                ->labelText('This is the label')
                ->labelFont(new NotoSans(20))
                ->labelAlignment(LabelAlignment::Center)
                ->validateResult(false)
                ->build();

            // Save the QR code to the specified path
            $result->saveToFile($filePath);

            if (!file_exists($filePath)) {
                throw new Exception('QR code file does not exist.');
            }
    
            // Decode the QR code
            $reader = new QrReader($filePath);
            $decodedText = $reader->text();
    
            return [
                'success' => true,
                'file_path' => $filePath,
                'decoded_text' => $decodedText
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }



    public static function getIntContact1($num, $country)
    {
        // Remove any non-digit characters
        $phoneNumber = preg_replace('/\D/', '', $num);
    
        // Check if the number starts with '0' and replace with '233'
        if (strpos($phoneNumber, '0') === 0) {
            $phoneNumber = '233' . substr($phoneNumber, 1);
        }

        // Check if the number starts with '+'
        if (strpos($phoneNumber, '+') === 0) {
            $phoneNumber = substr($phoneNumber, 1);
        }

        return $phoneNumber;
    }

    public static function getIntContact($num, $country = 'ghana')
    {
        // Remove spaces, dashes, brackets etc
        $phoneNumber = trim($num);

        // Keep only digits and +
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Country codes
        $countryCodes = [
            'ghana' => '233',
            'nigeria' => '234',
            'kenya' => '254',
        ];

        $code = $countryCodes[strtolower($country)] ?? '233';

        // Convert +233xxxxxxxxx -> 233xxxxxxxxx
        if (strpos($phoneNumber, '+') === 0) {
            $phoneNumber = substr($phoneNumber, 1);
        }

        // Convert 0xxxxxxxxx -> 233xxxxxxxxx
        if (strpos($phoneNumber, '0') === 0) {
            $phoneNumber = $code . substr($phoneNumber, 1);
        }

        // If already starts with country code, leave it
        if (strpos($phoneNumber, $code) === 0) {
            return $phoneNumber;
        }

        // If plain local number like 24xxxxxxx
        if (strlen($phoneNumber) <= 10) {
            return $code . ltrim($phoneNumber, '0');
        }

        return $phoneNumber;
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


}
