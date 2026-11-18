<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::withCount('products')->orderBy('name')->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', Rule::unique('categories', 'name')],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active'   => ['required', 'boolean'],
        ]);

        Categories::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Categories $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Categories $category)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active'   => ['required', 'boolean'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Categories $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Kategori masih digunakan oleh produk.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}