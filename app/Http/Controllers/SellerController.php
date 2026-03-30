<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $totalProducts = Product::where('seller_id', $user->id)->count();
        $totalSales = OrderItem::where('seller_id', $user->id)->sum('quantity');
        $totalEarnings = OrderItem::where('seller_id', $user->id)
            ->whereHas('order', function ($query) {
                $query->where('payment_status', 'paid');
            })
            ->sum('subtotal');

        $recentOrders = OrderItem::where('seller_id', $user->id)
            ->with(['order.buyer', 'product'])
            ->latest()
            ->limit(10)
            ->get();

        return view('seller.dashboard', compact('totalProducts', 'totalSales', 'totalEarnings', 'recentOrders'));
    }

    public function products()
    {
        $user = Auth::user();
        $products = Product::where('seller_id', $user->id)
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function showCreateProduct()
    {
        $categories = \App\Models\Category::where('status', true)->get();
        return view('seller.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $slug = Str::slug($request->name) . '-' . time();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'seller_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect('/seller/products')->with('success', 'Product created successfully! Waiting for approval.');
    }

    public function showEditProduct($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);
        $categories = \App\Models\Category::where('status', true)->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $product->image,
            'status' => 'pending',
        ]);

        return redirect('/seller/products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = OrderItem::where('seller_id', $user->id)
            ->with(['order.buyer', 'product'])
            ->latest()
            ->paginate(10);

        return view('seller.orders', compact('orders'));
    }

    public function shipOrder($orderItemId)
    {
        $orderItem = OrderItem::where('seller_id', Auth::id())
            ->where('id', $orderItemId)
            ->with('order')
            ->firstOrFail();

        $order = $orderItem->order;
        
        $order->update(['status' => 'delivered']);

        return back()->with('success', 'Order marked as delivered!');
    }

    public function earnings()
    {
        $user = Auth::user();
        
        $totalEarnings = OrderItem::where('seller_id', $user->id)
            ->whereHas('order', function ($query) {
                $query->where('payment_status', 'paid');
            })
            ->sum('subtotal');

        $pendingEarnings = OrderItem::where('seller_id', $user->id)
            ->whereHas('order', function ($query) {
                $query->where('payment_status', 'pending');
            })
            ->sum('subtotal');

        $orders = OrderItem::where('seller_id', $user->id)
            ->with(['order.buyer', 'product'])
            ->latest()
            ->paginate(10);

        return view('seller.earnings', compact('totalEarnings', 'pendingEarnings', 'orders'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('seller.profile', compact('user'));
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
