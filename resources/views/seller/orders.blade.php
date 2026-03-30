@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>My Orders</h2>
    </div>
</div>

<div class="row mt-4">
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
                                <th>Price</th>
                                <th>Subtotal</th>
                                <th>Status</th>
                                <th>Action</th>
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
                                <td>${{ number_format($order->price, 2) }}</td>
                                <td>${{ number_format($order->subtotal, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->order->status == 'delivered' ? 'success' : ($order->order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->order->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->order->status !== 'delivered' && $order->order->status !== 'cancelled')
                                        <form method="POST" action="{{ route('seller.orders.ship', $order->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this order as delivered?')">
                                                <i class="fas fa-truck"></i> Ship / Deliver
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Completed</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No orders yet</td>
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
