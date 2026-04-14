@extends('template')

@section('title', 'Dashboard Staff')

@section('content')

{{-- Welcome Banner --}}
<div class="card welcome-card mb-4 p-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="text-white fw-bold mb-1">
                Welcome, {{ auth()->user()->name }}! 👋
            </h5>
            <p class="text-white opacity-75 mb-0 small">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card stat-card">
            <div class="stat-icon" style="background:#fff7ed;">
                <i class="bi bi-arrow-left-right" style="color:#ea580c;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:#ea580c; text-align: center;">{{ $myActive }}</div>
                <div class="text-muted small">Sedang Dipinjam</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="bi bi-check-circle" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:#16a34a; text-align: center;">{{ $myReturned }}</div>
                <div class="text-muted small">Sudah Kembali</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card stat-card">
            <div class="stat-icon" style="background:#eff6ff;">
                <i class="bi bi-box-seam" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:#2563eb; text-align: center;">{{ $totalItems }}</div>
                <div class="text-muted small">Total Stok Tersedia</div>
            </div>
        </div>
    </div>
</div>
@endsection
