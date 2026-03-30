@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('products') }}">
                    <div class="mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Min Price</label>
                        <input type="number" name="min_price" class="form-control" placeholder="0" value="{{ request('min_price') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Max Price</label>
                        <input type="number" name="max_price" class="form-control" placeholder="999999" value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100 mt-2">Clear</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row mb-3">
            <div class="col-md-12">
                <h2>All Products</h2>
            </div>
        </div>
        <div class="row">
            @forelse($products as $product)
            <div class="col-md-4 col-6 mb-4">
                <div class="card product-card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
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
                <div class="alert alert-info">No products found.</div>
            </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
