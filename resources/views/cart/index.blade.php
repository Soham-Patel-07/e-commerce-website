@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Shopping Cart</h2>
    </div>
</div>

@if($carts->isEmpty())
<div class="row mt-4">
    <div class="col-md-12">
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products') }}">Continue shopping</a>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-md-8">
        @foreach($carts as $cart)
        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        @if($cart->product->image)
                            <img src="{{ asset('storage/' . $cart->product->image) }}" class="img-fluid rounded" alt="{{ $cart->product->name }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 80px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6>{{ $cart->product->name }}</h6>
                        <p class="text-muted small mb-0">${{ number_format($cart->product->price, 2) }} each</p>
                    </div>
                    <div class="col-md-3">
                        <form method="POST" action="{{ route('cart.update', $cart->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="input-group">
                                <input type="number" name="quantity" class="form-control" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->quantity }}">
                                <button type="submit" class="btn btn-outline-secondary">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <h6>${{ number_format($cart->product->price * $cart->quantity, 2) }}</h6>
                    </div>
                    <div class="col-md-1 text-end">
                        <form method="POST" action="{{ route('cart.remove', $cart->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        <form method="POST" action="{{ route('cart.clear') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Clear Cart</button>
        </form>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>Total</strong>
                    <strong class="text-primary">${{ number_format($total, 2) }}</strong>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-primary w-100">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
