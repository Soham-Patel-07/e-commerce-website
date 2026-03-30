@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Manage Products</h2>
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
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Seller</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->seller->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->status == 'approved' ? 'success' : ($product->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->status === 'pending')
                                        <form method="POST" action="{{ route('admin.products.approve', $product->id) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.products.reject', $product->id) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning">Reject</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.products.delete', $product->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No products found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        {{ $products->links() }}
    </div>
</div>
@endsection
