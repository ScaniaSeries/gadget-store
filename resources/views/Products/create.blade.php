@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<h3>Tambah Produk</h3>

<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <div class="mb-3">
        <label for="product_code" class="form-label">Kode</label>
        <input type="text" name="product_code" id="product_code" class="form-control" value="{{ old('product_code') }}">
        @error('product_code') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Nama produk</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select name="category_id" id="category_id" class="form-select">
            <option value="">Pilih kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="brand" class="form-label">Merek</label>
        <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}">
        @error('brand') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Harga</label>
        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}">
        @error('price') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stok</label>
        <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', 0) }}">
        @error('stock') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection