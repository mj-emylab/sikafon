<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Jobs\resetPasswordJob;
use Carbon\Carbon;
use Str;

use App\Http\Controllers\AppBaseController;

class PasswordResetController extends AppBaseController
{

   public function createToken(Request $request)
   {
        try {
                $validator = Validator::make($request->all(), [
                    'findmeId' => 'required|string',
                ]);

                if($validator->fails()) {
                    return $this->errorResponse($validator->errors(), 422);
                }

                $user = User::where([['findme_id', $request->input('findmeId')], ['deleted_at', null]])
                        ->first();

                if (!$user)
                    return $this->errorResponse("We can't find an active user with that findme ID.", 401);

                $code = Helpers::generateVerificationCode();

                $passwordReset = PasswordReset::where('findme_id', $user->findme_id)->first();

                if (empty($passwordReset)){
                    $data = new PasswordReset();
                    $data->findme_id = $user->findme_id;
                    $data->token = $code;
                    $data->save();

                    resetPasswordJob::dispatch($user, $user->email, $code);
                } else {
                    $passwordReset->token = $code;
                    $passwordReset->update();
                    
                    resetPasswordJob::dispatch($user, $user->email, $code);

                }

                // $passwordReset = PasswordReset::updateOrCreate(
                //     ['findme_id' => $user->findme_id],
                //     [
                //         'findme_id' => $user->findme_id,
                //         'token' => $code
                //     ]
                // );

                // if ($user && $passwordReset)
                // resetPasswordJob::dispatch($user, $user->email, $code);

                return $this->successResponse("Please we've e-mailed your password reset code", 200);
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
   }

   // Finding token
   public function find(Request $request)
   {
        try {
            $passwordReset = PasswordReset::where('token', $request->code)->first();

            if (!$passwordReset)
                return $this->errorResponse("This password reset token is invalid.", 404);
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(360)->isPast()) {
                $passwordReset->delete();
                return $this->errorResponse("This password reset token is expired, try again", 404);
            }
            return response()->json($passwordReset, 200);

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

   //Resetting password
   public function reset(Request $request)
   {
       $request->validate([
           'password' => 'required|string',
           'findmeId' => 'required|string'
       ]);

       $passwordReset = PasswordReset::where('findme_id', $request->input('findmeId'))->first();

       if (!$passwordReset)
           return $this->errorResponse("This password reset token is Invalid.", 404);

        $user = User::where('findme_id', $passwordReset->findme_id)->first();
        if (!$user)
           return $this->errorResponse("We can't find a user with the entered findme ID.", 404);


        $user->password = Hash::make($request->input('password'));
        $user->save();
        $passwordReset->delete();
        
       return $this->successResponse($user, 200);
   }

}
