@extends('layouts.app')

@section('title', 'My Earnings')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>My Earnings</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h3>${{ number_format($totalEarnings, 2) }}</h3>
                <p class="mb-0">Total Earnings (Paid)</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                <h3>${{ number_format($pendingEarnings, 2) }}</h3>
                <p class="mb-0">Pending Earnings</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <h4>Order History</h4>
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
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->order_id }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->order->buyer->name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>${{ number_format($order->subtotal, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->order->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
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

<div class="row">
    <div class="col-md-12">
        {{ $orders->links() }}
    </div>
</div>
@endsection
