<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBuyers = User::where('role', 'buyer')->count();
        $totalSellers = User::where('role', 'seller')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');

        $recentOrders = Order::with('buyer')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuyers',
            'totalSellers',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }

    public function users()
    {
        $buyers = User::where('role', 'buyer')->latest()->paginate(10);
        $sellers = User::where('role', 'seller')->latest()->paginate(10);

        return view('admin.users', compact('buyers', 'sellers'));
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => true]);

        return back()->with('success', 'User blocked successfully!');
    }

    public function unblockUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_blocked' => false]);

        return back()->with('success', 'User unblocked successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    public function products()
    {
        $products = Product::with(['seller', 'category'])
            ->latest()
            ->paginate(10);

        return view('admin.products', compact('products'));
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'approved']);

        return back()->with('success', 'Product approved successfully!');
    }

    public function rejectProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'rejected']);

        return back()->with('success', 'Product rejected!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        $orders = Order::with(['buyer', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        return view('admin.orders', compact('orders'));
    }
}
