<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('master-data.category.index', compact('categories'));
    }
    
    public function create()
    {
        return view('master-data.category.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ]);
    
        Category::create($validated);
    
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }
}
