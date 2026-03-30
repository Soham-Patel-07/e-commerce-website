@extends('layouts.app')

@section('title', 'My Products')

@section('content')
<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h2>My Products</h2>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
</div>

<div class="row mt-4">
    @forelse($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="text-muted small">{{ $product->category->name }}</p>
                <h6 class="text-primary">${{ number_format($product->price, 2) }}</h6>
                <p class="small">Stock: {{ $product->quantity }}</p>
                <span class="badge bg-{{ $product->status == 'approved' ? 'success' : ($product->status == 'rejected' ? 'danger' : 'warning') }}">
                    {{ ucfirst($product->status) }}
                </span>
            </div>
            <div class="card-footer bg-white">
                <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form method="POST" action="{{ route('seller.products.delete', $product->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-md-12">
        <div class="alert alert-info">
            No products yet. <a href="{{ route('seller.products.create') }}">Add your first product</a>
        </div>
    </div>
    @endforelse
</div>

<div class="row">
    <div class="col-md-12">
        {{ $products->links() }}
    </div>
</div>
@endsection
