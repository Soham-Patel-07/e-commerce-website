<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $orders = Order::where('buyer_id', $user->id)
            ->with(['orderItems.product'])
            ->latest()
            ->paginate(10);

        $cartCount = Cart::where('buyer_id', $user->id)->sum('quantity');

        return view('buyer.dashboard', compact('orders', 'cartCount'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('buyer_id', $user->id)
            ->with(['orderItems.product', 'payment'])
            ->latest()
            ->paginate(10);

        return view('buyer.orders', compact('orders'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('buyer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->update($request->only(['name', 'phone', 'address']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}
