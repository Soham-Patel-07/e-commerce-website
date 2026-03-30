@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Welcome, {{ Auth::user()->name }}!</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                <h3>{{ $cartCount }}</h3>
                <p class="mb-0">Items in Cart</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-box fa-3x text-success mb-3"></i>
                <h3>{{ $orders->total() }}</h3>
                <p class="mb-0">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-user fa-3x text-info mb-3"></i>
                <p class="mb-0"><a href="{{ route('buyer.profile') }}">Edit Profile</a></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <h4>Recent Orders</h4>
    </div>
</div>

<div class="row mt-2">
    @forelse($orders->take(5) as $order)
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Order #{{ $order->id }}</span>
                <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                <p class="mb-1"><strong>Items:</strong> {{ $order->orderItems->count() }}</p>
                <p class="mb-0"><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('buyer.orders') }}" class="btn btn-sm btn-primary">View Details</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-md-12">
        <div class="alert alert-info">No orders yet. <a href="{{ route('products') }}">Start shopping</a></div>
    </div>
    @endforelse
</div>
@endsection
