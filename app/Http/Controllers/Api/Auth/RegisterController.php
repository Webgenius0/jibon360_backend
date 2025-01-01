<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OtpMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'phone'     => 'required|unique:users,phone',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
        }

        try {
            $otp          = rand(1000, 9999);
            $otpExpiresAt = Carbon::now()->addMinutes(5);

            //Send OTP email
            try {
                Mail::to($request->input('email'))->send(new OtpMail($otp));
            } catch (Exception $e) {
                return Helper::jsonResponse(false, 'Failed to send OTP to email. Please try again.', 500, ['error' => $e->getMessage()]);
            }

            $user = User::create([
                'name'           => $request->input('name'),
                'email'          => $request->input('email'),
                'phone'          => $request->input('phone'),
                'password'       => Hash::make($request->input('password')),
                'otp'            => $otp,
                'otp_expires_at' => $otpExpiresAt
            ]);

            $token = auth('api')->login($user);

            return response()->json([
                'status'     => true,
                'message'    => 'User Successfully Registered',
                'code'       => 200,
                'token_type' => 'bearer',
                'token'      => $token,
                'data'       => $user,
            ], 200);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An error occurred while register new account', 500, ['error' => $e->getMessage()]);
        }
    }
    public function VerifyEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp'   => 'required|digits:4',
            ]);

            if ($validator->fails()) {
                return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
            }

            $user = User::where('email', $request->input('email'))->first();

            //! Check if email has already been verified
            if ($user->email_verified_at !== null) {
                return Helper::jsonResponse(false, 'Your email has already been verified. Please login to continue.', 409);
            }

            if ($user->otp !== $request->input('otp')) {
                return Helper::jsonResponse(false, 'Invalid OTP. Please try again.', 422);
            }

            //* Check if OTP has expired
            if (Carbon::parse($user->otp_expires_at)->isPast()) {
                return Helper::jsonResponse(false, 'OTP has expired. Please request a new OTP.', 422);
            }

            //* Verify the email
            $user->email_verified_at = now();
            $user->otp               = null;
            $user->otp_expires_at    = null;
            $user->save();

            //? Generate an access token for the user
            //$token = auth('api')->login($user);

            return response()->json([
                'status'     => true,
                'message'    => 'Email verified successfully.',
                'code'       => 200,
                'token_type' => 'bearer',
                //'token'      => $token,
                'data'       => $user,
            ], 200);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An unexpected error occurred.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function ResendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return Helper::jsonResponse(false, 'Validation failed', 422, $validator->errors());
            }

            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return Helper::jsonResponse(false, 'User not found.', 404);
            }

            if ($user->email_verified_at) {
                return Helper::jsonResponse(false, 'Email already verified.', 400);
            }

            $newOtp               = rand(1000, 9999);
            $otpExpiresAt         = Carbon::now()->addMinutes(5);
            $user->otp            = $newOtp;
            $user->otp_expires_at = $otpExpiresAt;
            $user->save();

            //* Send the new OTP to the user's email
            Mail::to($user->email)->send(new OTPMail($user->otp));

            return Helper::jsonResponse(true, 'A new OTP has been sent to your email.', 200);
        } catch (Exception $e) {
            return Helper::jsonResponse(false, 'An unexpected error occurred.', 500, ['error' => $e->getMessage()]);
        }
    }
}
