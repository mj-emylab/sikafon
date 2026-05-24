<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserResource;
use Response;

use App\Models\CardUser;
use App\Models\Card;
use App\Models\Code;
use App\Models\Pin;
use App\Models\Log;
use Carbon\Carbon;
use App\Http\Resources\PinResource;

use App\Helper\Helpers;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Jobs\DynamicMailJob;
use App\Jobs\EnquiryJob;

use PragmaRX\Countries\Package\Countries;


/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{

    public function selfCreate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'first_name' =>
                    'required|string',

                'last_name' =>
                    'required|string',

                'phone' =>
                    'required|string',

                'sex' =>
                    'required|string',

                'email' =>
                    'required|email|unique:users,email',

                'dob' =>
                    'required|date',

                'address' =>
                    'required|string',

                'pin' =>
                    'required|string|min:4|max:6',

                'password' =>
                    'required|string|min:6',

                'card_id' =>
                    'required|string|unique:users,card_id',
            ]
        );

        if ($validator->fails()) {

            return $this->sendError(
                $validator->errors()->first()
            );
        }


        $verifiedCard = CardUser::where('card_no', $request->card_id)
            ->first();

        if (!$verifiedCard) {
            return $this->sendError("Card must be verified with selfie before creating user");
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Generate QR Code
            |--------------------------------------------------------------------------
            */

            $code =
                Helpers::generateVerificationCode();

            $qrCodeResult =
                Helpers::generateQRCode(
                    $code
                );

            if (
                !$qrCodeResult['success']
            ) {

                DB::rollBack();

                return $this->sendError(
                    'Failed to generate QR code'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Normalize Phone
            |--------------------------------------------------------------------------
            */

            $country = 'ghana';

            $phone =
                Helpers::getIntContact(
                    $request->phone,
                    $country
                );


            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = new User();

            $user->address = $request->address;

            $user->sex = $request->sex;

            $user->phone =
                $phone;

            $user->card_id =
                strtoupper(
                    $request->card_id
                );

            $user->card_type =
                'GHANACARD';

            $user->email =
                strtolower(
                    $request->email
                );

            $user->dob =
                Carbon::parse(
                    $request->dob
                )->format('Y-m-d');

            $user->first_name =
                ucwords(
                    $request->first_name
                );

            $user->middle_name =
                $request->middle_name
                    ? ucwords(
                        $request->middle_name
                    )
                    : null;

            $user->last_name =
                ucwords(
                    $request->last_name
                );

            $user->password =
                Hash::make(
                    $request->password
                );

            $user->code =
                $code;

            $user->code_url =
                'storage/codes/' .
                basename(
                    $qrCodeResult['file_path']
                );

            $user->save();

            /*
            |--------------------------------------------------------------------------
            | Save PIN
            |--------------------------------------------------------------------------
            */

            Pin::create([

                'user_id' =>
                    $user->id,

                'code' =>
                    Hash::make(
                        $request->pin
                    ),
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Send Welcome Email
            |--------------------------------------------------------------------------
            */

            $msg =
                "Congratulations! "
                . "Your SIKAFON account has been created successfully.";

            DynamicMailJob::dispatch(
                $user,
                'Registration Email',
                $msg
            );

            // log
            $log = Log::create([

                'user_id' =>  $user->id,

                // 'app_id' => 'integer',
                
                'logable_type' => 'App\Models\User',
                'logable_id' => $user->id,
                'about' => 'Self Registered',
                
            ]);

            return $this->sendResponse(
                new UserResource($user),
                'User registered successfully'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'first_name' =>
                    'required|string',

                'last_name' =>
                    'required|string',

                'phone' =>
                    'required|string',

                'sex' =>
                    'required|string',

                'email' =>
                    'required|email|unique:users,email',

                'dob' =>
                    'required|date',

                'address' =>
                    'required|string',

                'pin' =>
                    'required|string|min:4|max:6',

                'password' =>
                    'required|string|min:6',

                'card_id' =>
                    'required|string|unique:users,card_id',
            ]
        );

        if ($validator->fails()) {

            return $this->sendError(
                $validator->errors()->first()
            );
        }


        $verifiedCard = CardUser::where('card_no', $request->card_id)
            ->first();

        if (!$verifiedCard) {
            return $this->sendError("Card must be verified with selfie before creating user");
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Generate QR Code
            |--------------------------------------------------------------------------
            */

            $code =
                Helpers::generateVerificationCode();

            $qrCodeResult =
                Helpers::generateQRCode(
                    $code
                );

            if (
                !$qrCodeResult['success']
            ) {

                DB::rollBack();

                return $this->sendError(
                    'Failed to generate QR code'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Normalize Phone
            |--------------------------------------------------------------------------
            */

            $country = 'ghana';

            $phone =
                Helpers::getIntContact(
                    $request->phone,
                    $country
                );


            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = new User();

            $user->address = $request->address;

            $user->sex = $request->sex;

            $user->phone =
                $phone;

            $user->card_id =
                strtoupper(
                    $request->card_id
                );

            $user->card_type =
                'GHANACARD';

            $user->email =
                strtolower(
                    $request->email
                );

            $user->dob =
                Carbon::parse(
                    $request->dob
                )->format('Y-m-d');

            $user->first_name =
                ucwords(
                    $request->first_name
                );

            $user->middle_name =
                $request->middle_name
                    ? ucwords(
                        $request->middle_name
                    )
                    : null;

            $user->last_name =
                ucwords(
                    $request->last_name
                );

            $user->password =
                Hash::make(
                    $request->password
                );

            $user->code =
                $code;

            $user->code_url =
                'storage/codes/' .
                basename(
                    $qrCodeResult['file_path']
                );

            $user->save();

            /*
            |--------------------------------------------------------------------------
            | Save PIN
            |--------------------------------------------------------------------------
            */

            Pin::create([

                'user_id' =>
                    $user->id,

                'code' =>
                    Hash::make(
                        $request->pin
                    ),
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Send Welcome Email
            |--------------------------------------------------------------------------
            */

            $msg =
                "Congratulations! "
                . "Your SIKAFON account has been created successfully.";

            DynamicMailJob::dispatch(
                $user,
                'Registration Email',
                $msg
            );

            // log
            $log = Log::create([

                'user_id' =>  Auth::id(),

                // 'app_id' => 'integer',
                
                'logable_type' => 'App\Models\User',
                'logable_id' => $user->id,
                'about' => 'Adding user',
                
            ]);

            return $this->sendResponse(
                new UserResource($user),
                'User registered successfully'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }

    public function agentStatus($id)
    {
        $user = auth()->user();
        if (!$user) return $this->sendError('Authentication required', 401);

        $check = User::find($id);

        if (empty($check)) {
            return $this->sendError('User not found');
        }

        $check->user_type = $check->user_type == 2? 0 : 2;
        $check->update();

        // Log user activity
        $newLog = Log::create([
            'user_id' =>  Auth::id(),
            // 'app_id' => 'integer',
            'logable_type' => 'App\Models\User',
            'logable_id' => $check->id,
            'about' => 'User Agent Status Changed',
            
        ]);

        return $this->sendSuccess('Data updated successfully');
    }


    // users, clients user type 2 and user 0
    public function users(Request $request)
    {
        // $query =  User::with('user')->where('user_type', 0);
        $query =  User::where('user_type', 0);


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

    public function clients(Request $request)
    {
        $query =  User::with('user', 'page', 'chat')->where('status', 1);


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







    public function testCountryData () {
        $number = '+447398229866';
        // $number = '+233559148214';
        $body = "Hello from emjay";

        // \Log::info(env('APP_NAME'));
        // php artisan config:clear
        return $body;

        // $data = "Your data to encode in QR code";
        // generateAndDecodeQRCode($data);
    }

    public function testAddress(Request $request)
    {
        // $ip = '49.35.41.195'; //For static IP address get
        $ip = $request->ip(); //Dynamic IP address get
        $data = \Location::get($ip);
        return $data;

        // {
        //     "ip": "49.35.41.195",
        //     "countryName": "India",
        //     "countryCode": "IN",
        //     "regionCode": "MH",
        //     "regionName": "Maharashtra",
        //     "cityName": "Navi Mumbai",
        //     "zipCode": "400701",
        //     "isoCode": null,
        //     "postalCode": null,
        //     "latitude": "19.1266",
        //     "longitude": "73.0136",
        //     "metroCode": null,
        //     "areaCode": "MH",
        //     "timezone": "Asia/Kolkata",
        //     "driver": "Stevebauman\\Location\\Drivers\\IpApi"
        // }
    }

    public function contact(Request $request)
    {
        try {
            $input = $request->all();

            $validator = Validator::make($request->all(), [
                'msg' => 'required|string',
                'email'    => 'required|string|email',
                'name'    => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            
            /** @var Contact $contact */
            $input['user_id'] = Auth::id();
            $contact = Contact::create($input);

            $msg = $request->msg;
            $email = Helpers::getFlagValue('app-email');
            if ($email != '') {
                // $msg = $msg;
                EnquiryJob::dispatch([
                    "email"=> $email, 
                    "sender" => $request->email,
                    "first_name" => "NL Admin",
                    "msg" => $msg,
                    "title" => "Enquiry Email",
                ]);
            }

            // \Log::info($request);

            return $this->sendSuccess('Sent successfully');

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    // Login User
    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $login = trim($request->email);
            $password = $request->password;

            /*
            |--------------------------------------------------------------------------
            | Detect login type
            |--------------------------------------------------------------------------
            */
            $field = 'email';
            $value = $login;

            // If not email, assume phone
            if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {

                $field = 'phone';

                // Normalize phone exactly like registration
                $value = Helpers::getIntContact(
                    $login,
                    'ghana'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Attempt authentication
            |--------------------------------------------------------------------------
            */
            if (!Auth::attempt([
                $field => $value,
                'password' => $password
            ])) {

                return $this->sendError(
                    "Email/Phone or password invalid"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Get authenticated user
            |--------------------------------------------------------------------------
            */
            $user = User::where($field, $value)->first();

            if (!$user || !Hash::check($password, $user->password)) {

                return $this->sendError(
                    "Email/Phone or password invalid"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Login notification
            |--------------------------------------------------------------------------
            */
            $msg = "A new successful login into your sikafon account: "
                . Carbon::now()->toDayDateTimeString();

            DynamicMailJob::dispatch(
                $user,
                'Authentication Email',
                $msg
            );

            /*
            |--------------------------------------------------------------------------
            | Create token
            |--------------------------------------------------------------------------
            */
            $tokenResult = $user
                ->createToken('authToken')
                ->plainTextToken;

            return $this->sendResponse([
                'token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 'User authenticated successfully');

        } catch (Exception $error) {

            return $this->sendError(
                $error->getMessage()
            );
        }
    }

    /**
     * Logout user
     * GET /logout
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return $this->sendResponse('Logged out successfully', 200);
    }



    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $users = $query->get();

        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully');
    }

    public function makeAgent(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (empty($user)) {
            return $this->sendError('User not found');
        }
        
        $user->user_type = 2;
        $user->update();

        return $this->sendSuccess('Done successfully');
    }

    public function changePin(Request $request)
    {
        $input = $request->all();

        $check = Pin::where('user_id', Auth::id())->get();
        if (!empty($check)) {
            foreach ($check as $value) {
                $del = Pin::find($value->id);
                if (!empty($del)) {
                    $del->delete();
                }
            }
        }

        /** @var Pin $pin */
        $input['user_id'] = Auth::id(); //from front end and email, phone
        $input['code'] = $request->pin;
        $pin = Pin::create($input);

        $msg = "Your new sikafon pin (". $request->pin .") was changed successfully. #SIKAFON ". Carbon::now()->toDayDateTimeString();
        DynamicMailJob::dispatch(auth()->user(), 'PIN Email', $msg);

        return $this->sendSuccess('Done successfully');
    }

    public function changePass(Request $request)
    {
        $user = User::find(Auth::id());

        if (empty($user)) {
            return $this->sendError('User not found');
        }
        
        $user->password = Hash::make($request->password);
        $user->update();

        $msg = "Your new sikafon password was updated successfully. #SIKAFON ". Carbon::now()->toDayDateTimeString();
        DynamicMailJob::dispatch(auth()->user(), 'Password Reset Email', $msg);

        return $this->sendSuccess('Done successfully');
    }

    public function contactUs(Request $request)
    {
        return $this->sendResponse([
            'phone' => '0559148214',
            'email' => 'yakubumuhammedjaamiu@gmail.com',
            'address' => 'No 20 East Legon',
        ], 'Contact fetched successfully');
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $validator = Validator::make(
                $request->all(),
                [

                    'first_name' =>
                        'required|string',

                    'last_name' =>
                        'required|string',

                    'phone' =>
                        'required|string',

                    'email' =>
                        'required|email|unique:users,email',

                    'dob' =>
                        'required|date',
                    
                    'sex' =>
                        'required|string',

                    'address' =>
                        'required|string',

                    'pin' =>
                        'required|string|min:4|max:6',

                    'password' =>
                        'required|string|min:6',

                    'card_id' =>
                        'required|string|unique:users,card_id',
                ]
            );

            if ($validator->fails()) {

                return $this->sendError(
                    $validator->errors()->first()
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Generate QR Code
            |--------------------------------------------------------------------------
            */

            $code =
                Helpers::generateVerificationCode();

            $qrCodeResult =
                Helpers::generateQRCode(
                    $code
                );

            if (
                !$qrCodeResult['success']
            ) {

                DB::rollBack();

                return $this->sendError(
                    'Failed to generate QR code'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Normalize Phone
            |--------------------------------------------------------------------------
            */

            $country = 'ghana';

            $phone =
                Helpers::getIntContact(
                    $request->phone,
                    $country
                );

            /*
            |--------------------------------------------------------------------------
            | Verify Ghana Card
            |--------------------------------------------------------------------------
            */

            $ghanaCard =
                Helpers::verifyCard(
                    $request->first_name,
                    $request->last_name,
                    $request->card_id
                );

            if (
                !$ghanaCard['success']
            ) {

                DB::rollBack();

                return $this->sendError(
                    $ghanaCard['message']
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = new User();

            $user->address =
                ucwords(
                    $request->address
                );

            $user->phone =
                $phone;
            
            $user->sex = $request->sex;

            $user->card_id =
                strtoupper(
                    $request->card_id
                );

            $user->card_type =
                'GHANACARD';

            $user->email =
                strtolower(
                    $request->email
                );

            $user->dob =
                Carbon::parse(
                    $request->dob
                )->format('Y-m-d');

            $user->first_name =
                ucwords(
                    $request->first_name
                );

            $user->middle_name =
                $request->middle_name
                    ? ucwords(
                        $request->middle_name
                    )
                    : null;

            $user->last_name =
                ucwords(
                    $request->last_name
                );

            $user->password =
                Hash::make(
                    $request->password
                );

            $user->code =
                $code;

            $user->code_url =
                'storage/codes/' .
                basename(
                    $qrCodeResult['file_path']
                );

            $user->save();

            /*
            |--------------------------------------------------------------------------
            | Save PIN
            |--------------------------------------------------------------------------
            */

            Pin::create([

                'user_id' =>
                    $user->id,

                'code' =>
                    Hash::make(
                        $request->pin
                    ),
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Create Token
            |--------------------------------------------------------------------------
            */

            $tokenResult =
                $user->createToken(
                    'authToken'
                )->plainTextToken;


            /*
            |--------------------------------------------------------------------------
            | Send Welcome Email
            |--------------------------------------------------------------------------
            */

            $msg =
                "Congratulations! "
                . "Your SIKAFON account has been created successfully.";

            DynamicMailJob::dispatch(
                $user,
                'Registration Email',
                $msg
            );

            return $this->sendResponse(
                [

                    'token' =>
                        $tokenResult,

                    'token_type' =>
                        'Bearer',

                    'user' =>
                        new UserResource($user),
                ],
                'User registered successfully'
            );

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error($e);

            return $this->sendError(
                $e->getMessage()
            );
        }
    }

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store1(Request $request)
    {
        $input = $request->all();

        // /** @var User $user */
        // $user = User::create($input);

        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name'  => 'required|string',
                'phone'      => 'required|string',
                'email' => 'required|email|unique:users',
                'dob'      => 'required|string',
                'address'      => 'required|string',
                'pin'      => 'required|string',
                'password' => 'required|string',

                'card_id' => 'required|string',
            ]);

            if($validator->fails()) {
                return $this->sendError($validator->errors());
            }



            $code = Helpers::generateVerificationCode();
            $qrCodeResult = Helpers::generateQRCode($code);
            if (!$qrCodeResult['success']) {
                return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
            }

            $country = 'ghana';
            $phone = Helpers::getIntContact($request->phone, $country);


            // check Id verification
            $ghanaCard = Helpers::verifyCard(
                $request->first_name,
                $request->last_name,
                $request->card_id
            );

            if (!$ghanaCard['success']) {
                \Log::info('Card failed');
                \Log::info($request);

                return $this->sendError(
                    $ghanaCard['message']
                );
            }

            $data = new User();
            // $data->user_type = 4; // normal user
            $data->address = ucwords($request->address);
            $data->phone = $phone;
            // $data->description = $request->description;
            $data->card_id = $request->card_id;
            // $data->card_type = $request->card_type;
            $data->card_type = "GHANACARD";
            $data->email = $request->email;
            $data->dob = $request->dob;
            $data->first_name = ucwords($request->first_name);
            $data->middle_name = ucwords($request->middleName);
            $data->last_name = ucwords($request->last_name);
            $data->password = Hash::make($request->password);

            $data->code = $code;
            $data->code_url = "storage/codes/". basename($qrCodeResult['file_path']);

            $data->save();

            $pin = new Pin();
            $pin->user_id = $data->id;
            $pin->code = $request->pin;
            $pin->save();

            DB::commit();

            $tokenResult = $data->createToken('authToken')->plainTextToken;

            $msg = "Congratulations your SIKAFON account has been created successfully";

            DynamicMailJob::dispatch($data, 'Registration Email', $msg);

            return $this->sendResponse([
                'token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($data),
            ], 'User saved successfully');

        } catch (\Exception $ex) {
            \Log::info($ex);

            DB::rollback();
            return $this->sendError($ex->getMessage());
        }
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        // \Log::info('coaches notified successfully');
        return $request;

        // $input = $request->validated();

        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name'  => 'required|string',
                'phone'      => 'required|string',
                'email'      => 'required|string',
                'dob'      => 'required|string',
                'country'      => 'required|string',
                'state'      => 'required|string',
                // 'city'      => 'required|string',
                'area'      => 'required|string',
                'address'      => 'required|string',
                'userType' => 'required',
            ]);

            if($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $country = $request->country;
            $phone = Helpers::getIntContact($request->phone, $country);
            $flag = Helpers::getCountryData($country)['flag'];

            $image = Helpers::getImageUrlFromStorage($request, 'image', 'users');
            if($image) {
                // \Log::info('has image');
                // \Log::info($image);
                $user->image = $image;
            }

            $user->long = $request->long;
            $user->lat = $request->lat;
            $user->country = ucwords($request->country);
            $user->currency_symbol = $request->currencySymbol;
            $user->state = ucwords($request->state);
            // $user->state = ucwords($request->state);
            $user->description = $request->description;
            $user->city = ucwords($request->city);
            $user->address = ucwords($request->address);
            $user->area = ucwords($request->area);
            $user->phone = $phone;
            $user->flag = $flag;
            $user->dob = $request->dob;
            $user->first_name = ucwords($request->first_name);
            $user->middle_name = ucwords($request->middleName);
            $user->last_name = ucwords($request->last_name);

            if($user->updatePass == 1) {
                $user->password = Hash::make($request->password);
            }

            $user->update();

            
            DB::commit();
            $user = $user->refresh();
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // $user = \auth()->user();
            // $permissions = $user->permissions()->pluck('name');

            return $this->sendResponse([
                'token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 'User updated successfully');

            // return $this->sendResponse(new UserResource($user), 'User updated successfully');

        } catch (\Exception $ex) {
            DB::rollback();
            return $this->sendError($ex->getMessage());
        }
    }

    public function profile(Request $request)
    {
        /** @var User $user */
        $user = User::find(Auth::id());

        if (empty($user)) {
            return $this->sendError('User not found');
        }
        
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name'  => 'required|string',
                'phone'      => 'required|string',
                'email' => 'required|unique:employees,email,'.Auth::id(),
                // 'dob'      => 'required|string',
                // 'country'      => 'required|string',
                'address'      => 'required|string',
                'password' => 'required|string',
            ]);

            if($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $country = 'ghana';
            $phone = Helpers::getIntContact($request->phone, $country);

            $image = Helpers::getImageUrlFromStorage($request, 'image', 'users');
            if($image) {
                // \Log::info('has image');
                // \Log::info($image);
                $user->image = $image;
            }
            $user->address = ucwords($request->address);
            $user->phone = $phone;

            if($request->updatePass == 1) {
                if ( ! Hash::check($request->oldpassword, $user->password, [])) {

                    return $this->sendError("Password invalid");
                }
                $user->password = Hash::make($request->password);
            }

            $user->update();

            DB::commit();
            $user = $user->refresh();
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return $this->sendResponse([
                'token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 'User updated successfully');

        } catch (\Exception $ex) {
            DB::rollback();
            \Log::info($ex);
            return $this->sendError($ex->getMessage());
        }
        
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }
        return $this->sendSuccess('User deleted successfully');
    }

    // Change user password
    public function changePassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'password' => 'required|string',
                'email'    => 'required|string|email'
            ]);

            if ($validator->fails()) {
               return $this->sendError($validator->errors());
            }

            $user = User::find(Auth::id());
            if (empty($user)) {
                return $this->sendError('User not found');
            }
            $user->password = Hash::make($request->get('password'));
            $user->update();

            return $this->successResponse("Password changed successful", 200);

        } catch (\Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

    public function userSub (Request $request)
    {
        $nowDate = Carbon::now();
        $check = Subscription::where('user_id', auth()->user()->id)
            ->where('end_at', '>', $nowDate)
            ->where('status', 5)
            ->first();

        if(!empty($check)) {
            // return true;
            return $this->sendResponse(true, 'sub fetched successfully');
        }
        return $this->sendResponse(false, 'sub fetched successfully');
    }
}
