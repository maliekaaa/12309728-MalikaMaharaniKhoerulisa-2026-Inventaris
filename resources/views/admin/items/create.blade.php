@extends('template')

@section('title', 'Tambah Item')
@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Add Item Forms</h4>
    <p class="text-muted small mb-0">Please fill-all input form with right values.</p>
</div>

<div class="card p-4" style="max-width: 600px;">
    <form action="{{ route('items.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   placeholder="Contoh: Proyektor Epson" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">-- Choose Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Total <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" name="total_stock"
                       class="form-control @error('total_stock') is-invalid @enderror"
                       placeholder="0" min="0" value="{{ old('total_stock', 0) }}" required>
                <span class="input-group-text">item</span>
            </div>
            @error('total_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('items.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>

@endsection
