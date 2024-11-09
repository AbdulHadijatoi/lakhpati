<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // Send OTP via email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10); // OTP expires in 10 minutes

        // Store OTP in the database
        OtpVerification::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expiresAt, 'verified' => false]
        );

        // Send OTP email
        try{
            Mail::raw("Your password reset OTP is: $otp", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Password Reset OTP');
            });
        }catch(Exception $e){
            // some message
        }

        return response()->json([
            'message' => 'OTP sent to email.',
            'otp' => $otp
        ], 200);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric',
        ]);

        $otpVerification = OtpVerification::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpVerification) {
            return response()->json(['message' => 'Invalid OTP or email'], 400);
        }

        if (Carbon::now()->greaterThan($otpVerification->expires_at)) {
            return response()->json(['message' => 'OTP has expired'], 400);
        }

        $otpVerification->verified = true;
        $otpVerification->save();

        $user = User::where('email', $request->email)->first();
        return response()->json([
            'message' => 'OTP verified successfully.',
            'user' => $user
        ], 200);
    }

    public function changePassword(Request $request)
    {
        // Get the currently authenticated user
        

        // Validate input data
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::find($request->user_id);

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // Save the updated user
        $user->save();

        $token = $user->createToken('LAKHPATI')->accessToken;

        $data = [
            'token' => $token,
            'user' => $user
        ];
        return response()->json([
            'message' => 'OTP verified successfully.',
            $data
        ], 200);
    }
}
