<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function SendOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
            }

            $email = $request->input('email');
            $otp   = rand(1000, 9999);
            $user  = User::where('email', $email)->first();

            if ($user) {

                try {
                    Mail::to($email)->send(new OtpMail($otp));
                } catch (Exception $e) {
                    return Helper::jsonResponse(false, 'An error occurred.', 500, ['error' => $e->getMessage()]);
                }

                $user->update([
                    'otp'            => $otp,
                    'otp_expires_at' => Carbon::now()->addMinutes(5),
                ]);
                return Helper::jsonResponse(true, 'OTP Code Sent Successfully Please Check Your Email.', 200);
            } else {
                return Helper::jsonResponse(false, 'Invalid Email Address', 404);
            }
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function VerifyOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp'   => 'required|digits:4',
            ]);

            if ($validator->fails()) {
                return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
            }

            $email = $request->input('email');
            $otp   = $request->input('otp');
            $user = User::where('email', $email)->first();

            if (!$user) {
                return Helper::jsonResponse(false, 'User not found', 404);
            }

            if (Carbon::parse($user->otp_expires_at)->isPast()) {
                return Helper::jsonResponse(false, 'OTP has expired.', 400);
            }

            if ($user->otp !== $otp) {
                return Helper::jsonResponse(false, 'Invalid OTP', 400);
            }

            $user->update([
                'otp'             => null,
                'otp_expires_at'  => null,
                'is_otp_verified' => true,
                'otp_verified_at' => Carbon::now(),
            ]);

            return Helper::jsonResponse(true, 'OTP verified successfully', 200);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred during OTP verification', 500);
        }
    }

    public function ResetPassword(Request $request)
    {
        //dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email|exists:users,email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
            }

            $email       = $request->input('email');
            $newPassword = $request->input('password');

            $user = User::where('email', $email)->first();
            if (!$user) {
                return Helper::jsonResponse(false, 'User not found', 404);
            }

            if (!$user->is_otp_verified) {
                return Helper::jsonResponse(false, 'OTP not verified', 400);
            }

            if ($user->otp_expires_at && Carbon::parse($user->otp_expires_at)->isPast()) {
                return Helper::jsonResponse(false, 'OTP expired', 400);
            }

            $user->update([
                'password'        => Hash::make($newPassword),
                'is_otp_verified' => false,
                'otp'             => null,
                'otp_expires_at'  => null,
            ]);

            Auth::login($user);
            $token = auth('api')->login($user);

            return response()->json([
                'status'     => true,
                'message'    => 'Password rest Successfully',
                'code'       => 200,
                'token_type' => 'bearer',
                'token'      => $token,
                'data'       => $user,
            ], 200);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred during password reset', 500);
        }
    }
}
