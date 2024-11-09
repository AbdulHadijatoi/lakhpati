<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
        Mail::raw("Your password reset OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Password Reset OTP');
        });

        return response()->json(['message' => 'OTP sent to email.'], 200);
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

        return response()->json(['message' => 'OTP verified successfully.'], 200);
    }
}
