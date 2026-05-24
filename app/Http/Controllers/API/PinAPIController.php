<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePinAPIRequest;
use App\Http\Requests\API\UpdatePinAPIRequest;
use App\Models\Pin;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PinResource;
use Response;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helper\Helpers;
use Carbon\Carbon;

use App\Jobs\DynamicMailJob;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

/**
 * Class PinController
 * @package App\Http\Controllers\API
 */

class PinAPIController extends AppBaseController
{

    protected $baseUrl = 'https://localhost:56232';
    // protected $baseUrl = 'https://sikafon.net:5001'; // live


    public function index(Request $request)
    {
        $query = Pin::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $pins = $query->get();

        return $this->sendResponse(PinResource::collection($pins), 'Pins retrieved successfully');
    }


    // auth user
    public function store(Request $request)
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
        $code = Helpers::generateVerificationCode();
        $input['user_id'] = Auth::id(); //from front end and email, phone
        $input['code'] = $code;
        $pin = Pin::create($input);

        $msg = "Your new sikafon pin (". $code .") was created successfully. #SIKAFON ". Carbon::now()->toDayDateTimeString();
        DynamicMailJob::dispatch(auth()->user(), 'PIN Email', $msg);

        return $this->sendResponse(new PinResource($pin), 'Pin saved successfully');
    }

    // login in
    public function store2(Request $request)
    {
        $input = $request->all();

        $login = trim($request->email);

        /*
        |--------------------------------------------------------------------------
        | Detect email or phone
        |--------------------------------------------------------------------------
        */
        $field = 'email';
        $value = $login;

        // If not email, normalize as phone
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {

            $field = 'phone';

            $value = Helpers::getIntContact(
                $login,
                'ghana'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Find user
        |--------------------------------------------------------------------------
        */
        $user = User::where($field, $value)->first();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        /*
        |--------------------------------------------------------------------------
        | Delete old pins
        |--------------------------------------------------------------------------
        */
        $check = Pin::where('user_id', $user->id)->get();

        if ($check->count()) {

            foreach ($check as $value) {

                $del = Pin::find($value->id);

                if (!empty($del)) {
                    $del->delete();
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create new pin
        |--------------------------------------------------------------------------
        */
        $code = Helpers::generateVerificationCode();

        $input['user_id'] = $user->id;
        $input['code'] = $code;

        /** @var Pin $pin */
        $pin = Pin::create($input);

        /*
        |--------------------------------------------------------------------------
        | Send mail
        |--------------------------------------------------------------------------
        */
        $msg = "Your new sikafon pin (" . $code . ") was created successfully. "
            . "Incase you didn't initialize this, please ignore the message. "
            . "#SIKAFON "
            . Carbon::now()->toDayDateTimeString();

        DynamicMailJob::dispatch(
            $user,
            'PIN Email',
            $msg
        );

        return $this->sendResponse(
            new PinResource($pin),
            'Pin saved successfully'
        );
    }


    public function show($id)
    {
        /** @var Pin $pin */
        $pin = Pin::find($id);

        if (empty($pin)) {
            return $this->sendError('Pin not found');
        }

        return $this->sendResponse(new PinResource($pin), 'Pin retrieved successfully');
    }

    
    public function update($id, UpdatePinAPIRequest $request)
    {
        /** @var Pin $pin */
        $pin = Pin::find($id);

        if (empty($pin)) {
            return $this->sendError('Pin not found');
        }

        $pin->fill($request->all());
        $pin->save();

        return $this->sendResponse(new PinResource($pin), 'Pin updated successfully');
    }

    
    public function destroy($id)
    {
        /** @var Pin $pin */
        $pin = Pin::find($id);

        if (empty($pin)) {
            return $this->sendError('Pin not found');
        }

        $pin->delete();

        return $this->sendSuccess('Pin deleted successfully');
    }

    // login in
    public function findPin(Request $request)
    {
        $login = trim($request->email);

        /*
        |--------------------------------------------------------------------------
        | Detect email or phone + normalize phone
        |--------------------------------------------------------------------------
        */
        $field = 'email';
        $value = $login;

        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {

            $field = 'phone';

            $value = Helpers::getIntContact(
                $login,
                'ghana'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Find user
        |--------------------------------------------------------------------------
        */
        $user = User::where($field, $value)->first();

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        /*
        |--------------------------------------------------------------------------
        | Validate PIN
        |--------------------------------------------------------------------------
        */
        $pin = Pin::where('code', $request->pin)
            ->where('user_id', $user->id)
            ->first();

        if (empty($pin)) {
            return $this->sendError('Pin not found');
        }

        /*
        |--------------------------------------------------------------------------
        | Expiry check (10 mins)
        |--------------------------------------------------------------------------
        */
        if (Carbon::parse($pin->updated_at)->addMinutes(10)->isPast()) {
            $pin->delete();
            return $this->sendError("This pin is expired, try again");
        }

        /*
        |--------------------------------------------------------------------------
        | Create token
        |--------------------------------------------------------------------------
        */
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        /*
        |--------------------------------------------------------------------------
        | Notification
        |--------------------------------------------------------------------------
        */
        $msg = "A new successful pin login into your sikafon account: "
            . Carbon::now()->toDayDateTimeString();

        DynamicMailJob::dispatch(
            $user,
            'Authentication Email',
            $msg
        );

        return $this->sendResponse([
            'token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ], 'User authenticated successfully');
    }

    // auth user
    public function findPin2(Request $request)
    {
        /** @var Pin $pin */
        $pin = Pin::where('user_id', Auth::id())
            ->where('code', $request->pin)
            ->first();

        if (empty($pin)) {
            return $this->sendError('Pin not found');
        }

        // $pin->delete();
        // \Log::info($request);

        // return $this->sendSuccess('Pin verified successfully');
        return $this->sendResponse(new PinResource($pin), 'Pin verified successfully');
    }

    public function checkAgent(Request $request)
    {
        // \Log::info($request->username);
        $user = User::find(Auth::id());

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        // $this->baseUrl
        $apiUrl = "$this->baseUrl/api/authenticate";
        $response = Http::withOptions(['verify' => false])->timeout(10)->post($apiUrl, [
            'Username' => $request->username,
            'Password' => "checkin1",
        ]);

        \Log::info($request->username);
        \Log::info($response);

        if ($response->successful()) {
            return $this->sendResponse(new UserResource($user), 'User verified successfully');
        } else {
            return $this->sendError('Error getting user');
        }
    }
}
