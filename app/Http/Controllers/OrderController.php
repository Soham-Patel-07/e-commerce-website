<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $carts = Cart::where('buyer_id', $user->id)->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        $total = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('cart.checkout', compact('carts', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $carts = Cart::where('buyer_id', $user->id)->with('product')->get();

        if ($carts->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        $total = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        DB::beginTransaction();
        try {
            $order = Order::create([
                'buyer_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            foreach ($carts as $cart) {
                $product = $cart->product;
                $subtotal = $product->price * $cart->quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $cart->quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('quantity', $cart->quantity);
            }

            Cart::where('buyer_id', $user->id)->delete();

            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'method' => $request->payment_method,
                'status' => 'pending',
                'transaction_id' => 'TXN-' . time() . rand(1000, 9999),
            ]);

            DB::commit();

            if ($request->payment_method === 'cod') {
                $payment->update(['status' => 'completed', 'paid_at' => now()]);
                $order->update(['payment_status' => 'paid']);
            }

            return redirect('/buyer/orders')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error placing order: ' . $e->getMessage());
        }
    }

    public function myOrders()
    {
        $user = Auth::user();
        $orders = Order::where('buyer_id', $user->id)
            ->with(['orderItems.product', 'payment'])
            ->latest()
            ->paginate(10);

        return view('buyer.orders', compact('orders'));
    }

    public function payOrder(Request $request, $orderId)
    {
        $order = Order::where('buyer_id', Auth::id())->findOrFail($orderId);

        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Order already paid!');
        }

        $payment = $order->payment;
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        $order->update(['payment_status' => 'paid']);

        return back()->with('success', 'Payment successful!');
    }
}
