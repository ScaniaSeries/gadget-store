<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->string('q')->toString();
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('product_code', 'like', "%{$keyword}%")
                      ->orWhere('brand', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('category_id'),
                fn ($q) => $q->where('category_id', $request->category_id))
            ->orderBy('product_code')
            ->paginate(10)
            ->withQueryString();

        $categories = Categories::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Categories::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => ['required', 'string', 'max:50', Rule::unique('products', 'product_code')],
            'name'         => ['required', 'string', 'max:255'],
            'category_id'  => ['required', 'exists:categories,id'],
            'brand'        => ['nullable', 'string', 'max:100'],
            'price'        => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'deskripsi'    => ['nullable', 'string'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // ====== TAMBAHAN: method show ======
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
    // ====== AKHIR TAMBAHAN ======

    public function edit(Product $product)
    {
        $categories = Categories::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => ['required', 'string', 'max:50', Rule::unique('products', 'product_code')->ignore($product->id)],
            'name'         => ['required', 'string', 'max:255'],
            'category_id'  => ['required', 'exists:categories,id'],
            'brand'        => ['nullable', 'string', 'max:100'],
            'price'        => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'deskripsi'    => ['nullable', 'string'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}