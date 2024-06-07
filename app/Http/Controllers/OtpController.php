<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function submitMail(Request $request)
    {
        // dd($request->email);
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $expiresAt = Carbon::now()->addMinutes(5);
        $otp = rand(100000, 999999);
        // dd($otp);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $otp,
            'created_at' => Carbon::now(),
            'expires_at' => $expiresAt,
        ]);


        Mail::send('validateOtp', ['token' => $otp], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['message' => 'Nous vous avons envoyé un email de récupération!']);
    }

    public function showOtpForm($token)
    {
        return view('enterOtp', ['token' => $token]);
    }

    public function confirmOtp(Request $request)
    {
        $otp = $request->token;
        $otpvalide = DB::table('password_reset_tokens')->where(['token' => $request->token])->first();

        // dd($otpvalide);

        if ($otpvalide && $otp == $otpvalide->token && Carbon::now()->lessThan($otpvalide->expires_at)) {
            DB::table('password_reset_tokens')->where(['token' => $request->token])->delete();
            return view('login');
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
