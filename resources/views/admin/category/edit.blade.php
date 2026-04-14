@extends('template')

@section('content')
<div class="card p-4">
    <h5 class="mb-4 fw-semibold">Edit Data</h5>

    <form action="{{ route('category.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" placeholder="Masukkan nama" value="{{ $category->name}}">
        </div>

        <div class="mb-4">
            <label class="form-label">Division PJ</label>
            <select class="form-select @error ('division_pj') is-invalid @enderror" name="division_pj">
                <option selected disabled hidden="">-- Pilih Division --</option>
                <option value="Sarpras" {{ $category->division_pj == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                <option value="Tata Usaha" {{ $category->division_pj == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                <option value="Tefa" {{ $category->division_pj == 'Tefa' ? 'selected' : '' }}>Tefa</option>
            </select>
            @error('division_pj')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{  route('category.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection
