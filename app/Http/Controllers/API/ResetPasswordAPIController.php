<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResetPasswordAPIRequest;
use App\Http\Requests\API\UpdateResetPasswordAPIRequest;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ResetPasswordResource;
use Response;

use App\Helper\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ResetPasswordJob;
use Carbon\Carbon;
use Str;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

use App\Jobs\DynamicMailJob;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\API
 */

class ResetPasswordAPIController extends AppBaseController
{
    /**
     * Display a listing of the ResetPassword.
     * GET|HEAD /resetPasswords
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ResetPassword::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $resetPasswords = $query->get();

        return $this->sendResponse(ResetPasswordResource::collection($resetPasswords), 'Reset Passwords retrieved successfully');
    }

    /**
     * Store a newly created ResetPassword in storage.
     * POST /resetPasswords
     *
     * @param CreateResetPasswordAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email'
        ]);

        if($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (empty($user)) {
            return $this->sendError("We can't find an active user with your email.");
        }

        $resetPassword = ResetPassword::where('email', $request->email)->get();

        if (!empty($resetPassword)) {
            foreach ($resetPassword as $key => $value) {
                $resetPassword2 = ResetPassword::find($value->id);

                if (!empty($resetPassword2)) {
                    $resetPassword2->delete();
                }
            }
        }

        $code = Helpers::generateVerificationCode();

        $data = new ResetPassword();
        $data->email = $user->email;
        $data->code = $code;
        $data->save();

        ResetPasswordJob::dispatch($user, $user->email, $code);
        // ResetPasswordJob::dispatch($user, 'yakubumuhammedjaamiu@gmail.com', $code);
        Helpers::twilioSms($user->phone, "Hi ".$user->first_name."! "."Your reset password code is".$code."  In case you've not requested for this please ignore the message.");

        // $input = $request->all();

        // /** @var ResetPassword $resetPassword */
        // $resetPassword = ResetPassword::create($input);

        return $this->sendSuccess('Password code generated successfully');
    }

    /**
     * Display the specified ResetPassword.
     * GET|HEAD /resetPasswords/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ResetPassword $resetPassword */
        $resetPassword = ResetPassword::find($id);

        if (empty($resetPassword)) {
            return $this->sendError('Reset Password not found');
        }

        return $this->sendResponse(new ResetPasswordResource($resetPassword), 'Reset Password retrieved successfully');
    }

    /**
     * Update the specified ResetPassword in storage.
     * PUT/PATCH /resetPasswords/{id}
     *
     * @param int $id
     * @param UpdateResetPasswordAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateResetPasswordAPIRequest $request)
    {
        /** @var ResetPassword $resetPassword */
        $resetPassword = ResetPassword::find($id);

        if (empty($resetPassword)) {
            return $this->sendError('Reset Password not found');
        }

        $resetPassword->fill($request->all());
        $resetPassword->save();

        return $this->sendResponse(new ResetPasswordResource($resetPassword), 'ResetPassword updated successfully');
    }

    /**
     * Remove the specified ResetPassword from storage.
     * DELETE /resetPasswords/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ResetPassword $resetPassword */
        $resetPassword = ResetPassword::find($id);

        if (empty($resetPassword)) {
            return $this->sendError('Reset Password not found');
        }

        $resetPassword->delete();

        return $this->sendSuccess('Reset Password deleted successfully');
    }


    // Finding token
   public function find(Request $request)
   {
        try {
            $passwordReset = ResetPassword::where('code', $request->code)->first();

            if (empty($passwordReset)) {
                return $this->sendError("This password reset token is invalid.");
            }

            if (Carbon::parse($passwordReset->updated_at)->addMinutes(360)->isPast()) {
                $passwordReset->delete();
                return $this->sendError("This password reset token is expired, try again");
            }

            $passwordReset->status = 1;
            $passwordReset->update();
            
            return $this->sendSuccess('Code verified successfully');

        } catch (Exception $ex) {
            return $this->sendError($ex->getMessage());
        }
    }

   //Resetting password
   public function reset(Request $request)
   {
       $request->validate([
           'password' => 'required|string',
           'email' => 'required|string'
       ]);

       $passwordReset = ResetPassword::where('email', $request->input('email'))
                            ->where('status', 1)
                            ->first();

        if (empty($passwordReset)) {
           return $this->sendError("This password reset token is Invalid.");
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (empty($user)) {
           return $this->sendError("We can't find a user with the entered email.");
        }


        $user->password = Hash::make($request->input('password'));
        $user->update();
        $passwordReset->delete();

        $tokenResult = $user->createToken('authToken')->plainTextToken;
        DynamicMailJob::dispatch($user, 'Reset Password', 'Congratulations your Next level account password has been reset successfully');
        Helpers::twilioSms($user->phone, "Hi ".$user->first_name."! "."Congratulations your Next level account password has been reset successfully");

        // return $this->sendResponse(new UserResource($user), 'User saved successfully');
        return $this->sendResponse([
            'token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ], 'New password saved successfully');
        
    //    return $this->successResponse($user, 200);
   }
}
