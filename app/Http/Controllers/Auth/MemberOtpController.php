<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MemberLoginOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class MemberOtpController extends Controller
{
    public function showPhoneForm()
    {
        return view('auth.member-phone');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $phone = preg_replace('/\s+/', '', $request->phone);

        $key = 'member-otp:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'phone' => 'Too many requests. Please try again later.',
            ])->withInput();
        }

        RateLimiter::hit($key, 300);

        $user = User::where('phone', $phone)->where('role', 'member')->first();

        if (!$user) {
            return back()->withErrors([
                'phone' => 'Unable to send OTP to this phone number.',
            ])->withInput();
        }

        $otp = (string) random_int(100000, 999999);

        $otpRecord = MemberLoginOtp::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp_hash' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
            ]
        );

        if (!str_starts_with($phone, '88')) {
            $phone = '88' . $phone;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://103.230.63.50/bulksms/api');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'authUser' => 'HSIA',
            'authAccess' => 'HSIA@241#765',
            'destination' => $phone,
            'mask' => 'HSIA',
            'text' => "Your login OTP is {$otp}. It expires in 5 minutes.",
            'requestId' => time() . $user->id,
            'contentType' => 1,
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $serverOutput = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($serverOutput === false || $httpCode < 200 || $httpCode >= 300) {
            \Illuminate\Support\Facades\Log::error('OTP SMS request failed', [
                'user_id' => $user->id,
                'http_code' => $httpCode,
                'curl_error' => $curlError,
            ]);

            $otpRecord->delete();

            return back()->withErrors([
                'phone' => 'Unable to send OTP right now. Please try again.',
            ])->withInput();
        }

        session(['member_otp_user_id' => $user->id]);

        return redirect()->route('member.otp.verify.form')->with('success', 'If the SMS provider accepted your request, your OTP will arrive shortly.');
    }

    public function showVerifyForm()
    {
        if (!session()->has('member_otp_user_id')) {
            return redirect()->route('member.otp.phone');
        }

        return view('auth.member-otp');
    }

    public function resendOtp(Request $request)
    {
        $userId = session('member_otp_user_id');

        if (!$userId) {
            return redirect()->route('member.otp.phone')
                ->withErrors(['phone' => 'Please enter your phone number again.']);
        }

        $user = User::where('id', $userId)
            ->where('role', 'member')
            ->first();

        if (!$user) {
            return redirect()->route('member.otp.phone')
                ->withErrors(['phone' => 'Unable to verify this member.']);
        }

        $key = 'member-otp-resend:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors([
                'otp' => 'Too many resend requests. Please try again later.',
            ]);
        }

        RateLimiter::hit($key, 60);

        $otp = (string) random_int(100000, 999999);

        $otpRecord = MemberLoginOtp::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp_hash' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
            ]
        );

        $phone = preg_replace('/\s+/', '', $user->phone);

        if (!str_starts_with($phone, '88')) {
            $phone = '88' . $phone;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://103.230.63.50/bulksms/api');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'authUser' => 'HSIA',
            'authAccess' => 'HSIA@241#765',
            'destination' => $phone,
            'mask' => 'HSIA',
            'text' => "Your login OTP is {$otp}. It expires in 5 minutes.",
            'requestId' => time() . $user->id,
            'contentType' => 1,
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        $serverOutput = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($serverOutput === false || $httpCode < 200 || $httpCode >= 300) {
            \Illuminate\Support\Facades\Log::error('OTP resend SMS request failed', [
                'user_id' => $user->id,
                'http_code' => $httpCode,
                'curl_error' => $curlError,
            ]);

            $otpRecord->delete();

            return back()->withErrors([
                'otp' => 'Unable to resend OTP right now. Please try again.',
            ]);
        }

        return redirect()->route('member.otp.verify.form')
            ->with('success', 'If the SMS provider accepted your request, your new OTP will arrive shortly.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $userId = session('member_otp_user_id');

        if (!$userId) {
            return redirect()->route('member.otp.phone');
        }

        $otpRecord = MemberLoginOtp::where('user_id', $userId)->first();

        if (
            !$otpRecord ||
            $otpRecord->expires_at->isPast() ||
            $otpRecord->attempts >= 5
        ) {
            MemberLoginOtp::where('user_id', $userId)->delete();
            session()->forget('member_otp_user_id');

            return redirect()->route('member.otp.phone')
                ->withErrors(['phone' => 'Your OTP has expired. Please request a new one.']);
        }

        if (!Hash::check($request->otp, $otpRecord->otp_hash)) {
            $otpRecord->increment('attempts');

            return back()->withErrors([
                'otp' => 'Invalid OTP. Please try again.',
            ]);
        }

        $user = User::where('id', $userId)
            ->where('role', 'member')
            ->first();

        if (!$user) {
            $otpRecord->delete();
            session()->forget('member_otp_user_id');

            return redirect()->route('member.otp.phone');
        }

        $otpRecord->delete();
        session()->forget('member_otp_user_id');

        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.home');
    }
}
