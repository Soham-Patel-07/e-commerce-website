@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Seller Dashboard</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-box fa-3x text-primary mb-3"></i>
                <h3>{{ $totalProducts }}</h3>
                <p class="mb-0">Total Products</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-shopping-bag fa-3x text-success mb-3"></i>
                <h3>{{ $totalSales }}</h3>
                <p class="mb-0">Total Sales</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-dollar-sign fa-3x text-warning mb-3"></i>
                <h3>${{ number_format($totalEarnings, 2) }}</h3>
                <p class="mb-0">Total Earnings</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h4>Recent Orders</h4>
        <a href="{{ route('seller.orders') }}" class="btn btn-outline-primary btn-sm">View All Orders</a>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Buyer</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $item)
                            <tr>
                                <td>#{{ $item->order_id }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->order->buyer->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->subtotal, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->order->status == 'delivered' ? 'success' : ($item->order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($item->order->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->order->status !== 'delivered' && $item->order->status !== 'cancelled')
                                        <form method="POST" action="{{ route('seller.orders.ship', $item->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark as delivered?')">
                                                <i class="fas fa-truck"></i> Ship
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
