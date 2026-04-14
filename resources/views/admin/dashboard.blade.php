@extends('template')

@section('title', 'Dashboard Admin')
@section('content')

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

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background:#eff6ff;">
                <i class="bi bi-box-seam" style="color:#2563eb;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:#2563eb; text-align: center;">{{ $totalItems }}</div>
                <div class="text-muted small">Total Stock</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="bi bi-tags" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:#16a34a; text-align: center;">{{ $totalCategories }}</div>
                <div class="text-muted small">Category</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background:#fff7ed;">
                <i class="bi bi-arrow-left-right" style="color:#ea580c;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:#ea580c; text-align: center;">{{ $totalLendings }}</div>
                <div class="text-muted small">Current Lendings</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stat-card">
            <div class="stat-icon" style="background:#fdf4ff;">
                <i class="bi bi-people" style="color:#9333ea;"></i>
            </div>
            <div>
                <div class="fw-bold fs-4" style="color:#9333ea; text-align: center;">{{ $totalUsers }}</div>
                <div class="text-muted small">Total User</div>
            </div>
        </div>
    </div>
</div>
@endsection
