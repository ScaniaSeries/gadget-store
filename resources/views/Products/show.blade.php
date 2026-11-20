@extends('layouts.app')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Detail Produk</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            @if($product->gambar)
                <div class="col-md-4 mb-3">
                    <img src="{{ asset('storage/' . $product->gambar) }}"
                         alt="{{ $product->name }}"
                         class="img-fluid rounded">
                </div>
            @endif

            <div class="{{ $product->gambar ? 'col-md-8' : 'col-12' }}">
                <table class="table table-borderless">
                    <tr><th width="200">Kode</th><td>{{ $product->product_code }}</td></tr>
                    <tr><th>Nama Produk</th><td>{{ $product->name }}</td></tr>
                    <tr><th>Kategori</th><td>{{ $product->category->name ?? '-' }}</td></tr>
                    <tr><th>Merek</th><td>{{ $product->brand ?? '-' }}</td></tr>
                    <tr><th>Harga</th><td>Rp {{ number_format($product->price, 0, ',', '.') }}</td></tr>
                    <tr><th>Stok</th><td>{{ $product->stock }}</td></tr>
                    <tr><th>Deskripsi</th><td>{{ $product->deskripsi ?? '-' }}</td></tr>
                </table>

                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection