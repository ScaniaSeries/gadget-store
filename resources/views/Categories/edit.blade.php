@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<h3>Edit Kategori</h3>

<form method="POST" action="{{ route('categories.update', $category) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nama kategori</label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name', $category->name) }}">
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="is_active" class="form-label">Status</label>
        <select name="is_active" id="is_active" class="form-select">
            <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        @error('is_active')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection