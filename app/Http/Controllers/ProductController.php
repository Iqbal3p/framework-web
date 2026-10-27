<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view(
            'master-data.product.create',
            compact('categories')
        );
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function index(Request $request)
    {
        $query = Product::with('category');
    
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('code', 'like', "%{$keyword}%");
            });
        }
    
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();
    
        return view('master-data.product.index', compact('products', 'categories'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('master-data.product.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
    
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
