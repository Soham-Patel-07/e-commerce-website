@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Checkout</h2>
    </div>
</div>

<form method="POST" action="{{ route('place.order') }}">
    @csrf
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Shipping Address</label>
                        <textarea name="shipping_address" class="form-control" rows="3" required>{{ Auth::user()->address }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Payment Method</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                        <label class="form-check-label" for="cod">
                            <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                        <label class="form-check-label" for="card">
                            <i class="fas fa-credit-card"></i> Credit/Debit Card (Simulated)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                        <label class="form-check-label" for="paypal">
                            <i class="fab fa-paypal"></i> PayPal (Simulated)
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    @foreach($carts as $cart)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <small>{{ $cart->product->name }}</small>
                            <br>
                            <small class="text-muted">Qty: {{ $cart->quantity }}</small>
                        </div>
                        <small>${{ number_format($cart->product->price * $cart->quantity, 2) }}</small>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong class="text-primary">${{ number_format($total, 2) }}</strong>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
