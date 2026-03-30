@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>My Orders</h2>
    </div>
</div>

<div class="row mt-4">
    @forelse($orders as $order)
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>Order #{{ $order->id }}</strong>
                    <span class="ms-3 text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div>
                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                        Payment: {{ ucfirst($order->payment_status) }}
                    </span>
                    <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'primary') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('product.detail', $item->product->slug) }}">{{ $item->product->name }}</a>
                                </td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>${{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-3">
                    <strong>Shipping Address:</strong>
                    <p class="mb-0">{{ $order->shipping_address }}</p>
                </div>
                
                @if($order->payment_status === 'pending')
                <div class="mt-3">
                    <form method="POST" action="{{ route('order.pay', $order->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Pay Now</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-md-12">
        <div class="alert alert-info">No orders yet. <a href="{{ route('products') }}">Start shopping</a></div>
    </div>
    @endforelse
</div>

<div class="row">
    <div class="col-md-12">
        {{ $orders->links() }}
    </div>
</div>
@endsection
