@extends('layouts.app')

@section('title', 'Data Produk')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Produk</h3>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
    @endif
</div>

<form method="GET" class="form-row mb-3">
    <div class="col-md-5 mb-2">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode, nama, merek">
    </div>
    <div class="col-md-4 mb-2">
        <select name="category_id" class="form-control">
            <option value="">Semua kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-2">
        <button type="submit" class="btn btn-outline-primary btn-block">Cari / Filter</button>
    </div>
</form>

<div class="card">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">Gambar</th>
                    <th>Kode</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Merek</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}"
                                     alt="{{ $product->name }}"
                                     class="rounded"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted"
                                     style="width: 60px; height: 60px; font-size: 11px;">
                                    No image
                                </div>
                            @endif
                        </td>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category?->name ?? '-' }}</td>
                        <td>{{ $product->brand ?? '-' }}</td>
                        <td>Rp {{ number_format((float) $product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td class="text-nowrap">
                            <a class="btn btn-sm btn-info text-white" href="{{ route('products.show', $product) }}">Detail</a>

                            @if(auth()->user()->isAdmin())
                                <a class="btn btn-sm btn-warning" href="{{ route('products.edit', $product) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('products.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
</div>
@endsection