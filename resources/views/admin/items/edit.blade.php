@extends('template')

@section('title', 'Edit Item')
@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Edit Item</h4>
    <p class="text-muted small mb-0">Perbarui data item inventaris.</p>
</div>

<div class="card p-4" style="max-width: 600px;">
    <form action="{{ route('items.update', $items->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Item <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $items->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $items->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Total Stok <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" name="total_stock"
                       class="form-control @error('total_stock') is-invalid @enderror"
                       value="{{ old('total_stock', $items->total_stock) }}" min="0" required>
                <span class="input-group-text">item</span>
            </div>
            @error('total_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Jumlah Rusak</label>
            <div class="input-group">
                <input type="number" name="repair_count"
                       class="form-control @error('repair_count') is-invalid @enderror"
                       value="{{ old('repair_count', $items->repair_count) }}" min="0">
                <span class="input-group-text">item</span>
            </div>
            @error('repair_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Stok tersedia saat ini: <strong>{{ $items->available() }}</strong> item</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('items.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Update
            </button>
        </div>
    </form>
</div>

@endsection
