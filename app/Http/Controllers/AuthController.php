<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_blocked) {
                Auth::logout();
                return redirect('/login')->with('error', 'Your account has been blocked.');
            }

            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'seller') {
                return redirect('/seller/dashboard');
            } else {
                return redirect('/buyer/dashboard');
            }
        }

        return back()->with('error', 'Invalid email or password')->withInput();
    }

    public function showRegisterBuyerForm()
    {
        return view('auth.register-buyer');
    }

    public function registerBuyer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'buyer',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Auth::login($user);
        return redirect('/buyer/dashboard')->with('success', 'Account created successfully!');
    }

    public function showRegisterSellerForm()
    {
        return view('auth.register-seller');
    }

    public function registerSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'seller',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Auth::login($user);
        return redirect('/seller/dashboard')->with('success', 'Account created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
