<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        if ($user->is_blocked) {
            Auth::logout();
            return redirect('/login')->with('error', 'Your account has been blocked.');
        }

        if ($user->role !== $role) {
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'seller') {
                return redirect('/seller/dashboard');
            } elseif ($user->role === 'buyer') {
                return redirect('/buyer/dashboard');
            }
            return redirect('/');
        }

        return $next($request);
    }
}
