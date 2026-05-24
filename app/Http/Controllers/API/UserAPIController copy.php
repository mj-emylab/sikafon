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
use Carbon\Carbon;

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
        // \Log::info("login new");
        // \Log::info($request);

        $password = $request->password;
        $email = $request->email;

        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return $this->sendError("email or password invalid");
            }

            $user = User::where('email', $request->email)->first();

            if ( ! Hash::check($request->password, $user->password, [])) {

                return $this->sendError("email or password invalid");
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // $user = \auth()->user();
            // $permissions = $user->permissions()->pluck('name');

            return $this->sendResponse([
                'token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 'User authenticated successfully');

            $msg = "A new successful login into your sikafon account: ". Carbon::now()->toDayDateTimeString();
            DynamicMailJob::dispatch(auth()->user(), 'Authentication Email', $msg);

        } catch (Exception $error) {

            return $this->sendError($error->getMessage());
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

    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
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
                // 'dob'      => 'required|string',
                // 'country'      => 'required|string',
                'address'      => 'required|string',
                'password' => 'required|string',
            ]);

            if($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $card = Card::find($request->cartd_type);
            if (empty($card)) {
                return $this->sendError('Card not found');
            }

            $cardInfo = Helpers::verifyId($request->gh_card_id, $card->name)['cardInfo'];

            if ( trim(strtolower($cardInfo['first_name'])) !=  trim(strtolower($request->first_name))) {
                return $this->sendError('Please make sure you use your names as on your card');
            }

            if (Carbon::parse($cardInfo->issued) <= Carbon::now()) {
                return $this->sendError("Sorry this card can't be used at this time");
            }

            $country = $request->country;
            $phone = Helpers::getIntContact($phone->phone, $country);
            $flag = Helpers::getCountryData($country)['flag'];

            $data = new User();
            $data->user_type = 4; // normal user
            $data->country = ucwords($cardInfo['country']);
            $data->state = ucwords($cardInfo['state']);
            $data->city = ucwords($cardInfo['city']);
            $data->address = ucwords($request->address);
            $data->phone = $phone;
            // $data->description = $request->description;
            $data->flag = $flag;
            $data->email = $request->email;
            $data->dob = $cardInfo['dob'];
            $data->first_name = ucwords($cardInfo['first_name']);
            $data->middle_name = ucwords($cardInfo['middleName']);
            $data->last_name = ucwords($cardInfo['last_name']);
            $data->password = Hash::make($request->password);
            $data->save();


            $cardUser = new CardUser();
            $cardUser->user_id = $data->id;
            $cardUser->card_id = $request->card_type;
            $cardUser->code = '';
            $cardUser->issued_at = $cardInfo['issued'];
            $cardUser->expired_at = $cardInfo['expired'];
            $cardUser->save();

            $code = Helpers::generateVerificationCode();
            $qrCodeResult = Helpers::generateAndDecodeQRCode($code);
            if (!$qrCodeResult['success']) {
                return $this->sendError("Failed to generate QR code: " . $qrCodeResult['error']);
            }
            $code = new Code();
            $code->user_id = $data->id;
            $code->code = $code;
            $code->url = $qrCodeResult['file_path'];
            $code->codeable_type = 'App\Models\User';
            $code->codeable_id = $data->id;
            $code->save();

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

            $country = $request->country;
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
