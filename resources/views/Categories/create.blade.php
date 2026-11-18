@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<h3>Tambah Kategori</h3>

<form method="POST" action="{{ route('categories.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nama kategori</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="is_active" class="form-label">Status</label>
        <select name="is_active" id="is_active" class="form-select">
            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('is_active')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection