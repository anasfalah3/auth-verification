<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $token = Str::random(60);
        Cache::put('email_verification_' . $token, $request->email, now()->addMinutes(30));

        Mail::to($request->email)->send(new EmailVerificationEmail($token));
        return response()->json(['message' => 'Verification email sent']);

    }
    public function verifyEmail(Request $request, $token)
    {
        $email = Cache::get('email_verification_' . $token);
        
        if (!$email || $email !== $request->email) {
            return response()->json(['error' => 'Invalid token'], 400);
        }else{
            Cache::forget('email_verification_' . $token);
            return response()->json(['message' => 'Email verified successfully']);
        }

    }
}