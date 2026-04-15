@extends('template')

@section('title', 'List Items')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">List Items</h4>
        <p class="text-muted small mb-0">Check the list of inventory items and their stock availability</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">#</th>
                        <th>Category</th>
                        <th>Item Name</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Available Stock</th>
                        <th class="text-center">Lending Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $item->Category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td class="text-center">
                            {{ $item->total_stock }}
                        </td>
                        <td class="text-center">
                            @if($item->available() > 0)
                                <span class="badge bg-success">{{ $item->available() }}</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $item->lendingTotal() > 0 ? 'info text-dark' : 'light text-muted border' }}">
                                {{ $item->lendingTotal() }}
                            </span>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5 text-center text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            No item data available.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
