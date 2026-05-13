<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationCodeController extends Controller
{
    public function notice(Request $request): View
    {
        return view('auth.verify-code', ['email' => $request->email]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->verification_code === $request->code) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();

            auth()->login($user);

            return redirect()->route('dashboard')->with('status', 'Почта подтверждена!');
        }

        return back()->withErrors(['code' => 'Неверный код подтверждения.']);
    }
}