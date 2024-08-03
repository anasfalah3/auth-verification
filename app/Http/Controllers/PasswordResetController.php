<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $token = Str::random(60);
        Cache::put('password_reset_' . $token, $request->email, now()->addMinutes(30));

        Mail::to($request->email)->send(new PasswordResetEmail($token));
        return response()->json(['message' => 'Password reset email sent']);
    }
    public function PasswordResetEmail(Request $request, $token)
    {
        $email = Cache::get('password_reset_' . $token);

        if (!$email || $email !== $request->email) {
            return response()->json(['error' => 'Invalid token'], 400);
        } else {
            Cache::forget('password_reset_' . $token);
            return response()->json(['message' => 'Email verified successfully']);
        }
    }
}
