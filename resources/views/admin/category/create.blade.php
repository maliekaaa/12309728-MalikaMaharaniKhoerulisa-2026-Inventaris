@extends('template')

@section ('title', 'Add Category')
@section('content')
<div class="card p-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Add Category Form</h4>
        <p class="text-muted small mb-0">Please fill-all input form with right values.</p>
    </div>
    <br>
    <form action="{{ route('category.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter category name">
        </div>

        <div class="mb-4">
            <label class="form-label">Division PJ</label>
            <select class="form-select @error ('division_pj') is-invalid @enderror" name="division_pj">
                <option selected disabled hidden="">-- Pilih Division --</option>
                <option value="Sarpras" {{ old('division') == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                <option value="Tata Usaha" {{ old('division') == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                <option value="Tefa" {{ old ('division') == 'Tefa' ? 'selected' : '' }}>Tefa</option>
            </select>
            @error('division_pj')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{  route('category.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Submit
            </button>
        </div>
    </form>
</div>
@endsection
