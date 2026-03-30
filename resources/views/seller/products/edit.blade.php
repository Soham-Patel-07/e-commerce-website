@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Edit Product</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" step="0.01" min="0" value="{{ $product->price }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity (Stock)</label>
                        <input type="number" name="quantity" class="form-control" min="0" value="{{ $product->quantity }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="5">{{ $product->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="height: 100px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('seller.products') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
