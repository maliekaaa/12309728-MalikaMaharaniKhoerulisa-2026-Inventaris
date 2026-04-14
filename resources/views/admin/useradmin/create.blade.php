@extends('template')

@section('title', 'Tambah Admin')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Tambah Akun Admin</h4>
    <p class="text-secondary small mb-0">Isi formulir untuk menambahkan admin baru.</p>
</div>

<div class="card p-4" style="max-width: 500px;">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <input type="hidden" name="role" value="admin">

        <div class="mb-3">
            <label class="form-label">Nama <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="alert alert-info py-2 small">
            <i class="bi bi-info-circle me-1"></i>
            Password akan di-generate otomatis: <strong>4 huruf pertama email + ID user</strong>.
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('users.admin') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
