@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-6">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
        @else
            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                <i class="fas fa-image fa-5x text-muted"></i>
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
        <h2>{{ $product->name }}</h2>
        <p class="text-muted">Category: {{ $product->category->name }}</p>
        <p class="text-muted">Seller: {{ $product->seller->name }}</p>
        
        <h3 class="text-primary mb-3">${{ number_format($product->price, 2) }}</h3>
        
        <p class="{{ $product->quantity > 0 ? 'text-success' : 'text-danger' }}">
            <i class="fas fa-{{ $product->quantity > 0 ? 'check-circle' : 'times-circle' }}"></i>
            {{ $product->quantity > 0 ? $product->quantity . ' items in stock' : 'Out of stock' }}
        </p>
        
        <hr>
        
        <h5>Description</h5>
        <p>{{ $product->description ?? 'No description available.' }}</p>
        
        <hr>
        
        @auth
            @if(Auth::user()->role === 'buyer' && $product->quantity > 0)
                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-inline">
                    @csrf
                    <div class="input-group mb-3" style="max-width: 200px;">
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->quantity }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </form>
            @elseif(!Auth::check())
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-cart-plus"></i> Login to Buy
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fas fa-cart-plus"></i> Login to Buy
            </a>
        @endauth
    </div>
</div>
@endsection
