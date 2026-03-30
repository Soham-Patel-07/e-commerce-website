<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', true)->get();
        $products = Product::where('status', 'approved')
            ->with(['seller', 'category'])
            ->latest()
            ->paginate(12);

        return view('home', compact('categories', 'products'));
    }

    public function products(Request $request)
    {
        $query = Product::where('status', 'approved')->with(['seller', 'category']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::where('status', true)->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['seller', 'category'])
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
