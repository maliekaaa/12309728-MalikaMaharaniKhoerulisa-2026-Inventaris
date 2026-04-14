@extends('template')

@section('title', 'Staff Staff Edit')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Edit Staff</h4>
    <p class="text-secondary small mb-0">Perbarui data staff.</p>
</div>

<div class="card border-0 shadow-sm rounded-3" style="max-width: 500px;">
    <div class="card-body p-4">

        <form action="{{ route('staff.profile.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    New Password <span class="text-warning small">(opsional)</span>
                </label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin diubah">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Button -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('staff.admin') }}" class="btn text-dark px-4" style="background-color:#e0e0e0;">
                    Batal
                </a>
                <button type="submit" class="btn text-white px-4" style="background-color:#6f42c1;">
                    Update
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
