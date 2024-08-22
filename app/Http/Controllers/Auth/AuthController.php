<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:13',
            'password' => 'required|string|min:3|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'customer'
        ]);

        Customer::create([
            'user_id' => $user->id,
            'phone' => $user->phone,  // Ambil nomor telepon dari user
        ]);

        event(new Registered($user));

        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Registration successful. Please check your email to verify your account.');
    }




    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    // Coba autentikasi
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Cek jika email sudah diverifikasi
        if (!$user->hasVerifiedEmail()) {
            Auth::logout(); // Logout jika email belum diverifikasi
            return redirect()->back()
                ->withErrors(['email' => 'Email not verified. Please check your email and click on the verification link.'])
                ->withInput();
        }

        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard.index');
            case 'cashier':
                return redirect()->route('cashier.index');
            case 'customer':
                return redirect()->route('landing.index');
            default:
                return redirect()->route('dashboard');
        }
    }

    return redirect()->back()
        ->withErrors(['email' => 'Invalid credentials'])
        ->withInput();
}



    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }




    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found']);
        }
        if ($user->role == 'admin') {
            return back()->withErrors(['email' => 'Invalid Email']);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))->with('success', 'Password reset successfully')
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
