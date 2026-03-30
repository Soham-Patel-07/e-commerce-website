<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::where('buyer_id', $user->id)
            ->with('product')
            ->get();

        $total = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('cart.index', compact('carts', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::where('id', $productId)
            ->where('status', 'approved')
            ->firstOrFail();

        if ($product->quantity < 1) {
            return back()->with('error', 'Product is out of stock!');
        }

        $user = Auth::user();

        $cartItem = Cart::where('buyer_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + ($request->quantity ?? 1);
            if ($newQuantity > $product->quantity) {
                return back()->with('error', 'Not enough stock available!');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'buyer_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return redirect('/cart')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('buyer_id', Auth::id())->findOrFail($id);
        $product = $cart->product;

        $quantity = $request->quantity;
        if ($quantity < 1) {
            $cart->delete();
            return back();
        }

        if ($quantity > $product->quantity) {
            return back()->with('error', 'Not enough stock available!');
        }

        $cart->update(['quantity' => $quantity]);

        return back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = Cart::where('buyer_id', Auth::id())->findOrFail($id);
        $cart->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        Cart::where('buyer_id', Auth::id())->delete();

        return back()->with('success', 'Cart cleared!');
    }
}
