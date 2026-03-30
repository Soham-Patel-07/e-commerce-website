@extends('layouts.app')

@section('title', 'Home - E-Shop')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card bg-primary text-white">
            <div class="card-body py-5">
                <h1 class="display-4">Welcome to E-Shop</h1>
                <p class="lead">Your one-stop marketplace for quality products from trusted sellers</p>
                <a href="{{ route('products') }}" class="btn btn-light btn-lg">Browse Products</a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <h2>Categories</h2>
    </div>
    @foreach($categories as $category)
    <div class="col-md-2 col-6 mb-3">
        <a href="{{ route('products', ['category' => $category->id]) }}" class="text-decoration-none">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-folder fa-2x text-primary"></i>
                    <p class="mt-2 mb-0">{{ $category->name }}</p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>Latest Products</h2>
        <a href="{{ route('products') }}" class="btn btn-outline-primary">View All</a>
    </div>
</div>

<div class="row">
    @forelse($products as $product)
    <div class="col-md-3 col-6 mb-4">
        <div class="card product-card h-100">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif
            <div class="card-body">
                <h6 class="card-title">{{ $product->name }}</h6>
                <p class="text-muted small">{{ $product->category->name }}</p>
                <h5 class="text-primary">${{ number_format($product->price, 2) }}</h5>
                <p class="small text-muted">{{ $product->quantity > 0 ? $product->quantity . ' in stock' : 'Out of stock' }}</p>
            </div>
            <div class="card-footer bg-white border-top-0">
                <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-sm btn-outline-primary w-100">View Details</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-md-12">
        <div class="alert alert-info">No products available yet.</div>
    </div>
    @endforelse
</div>

<div class="row">
    <div class="col-md-12">
        {{ $products->links() }}
    </div>
</div>
@endsection
