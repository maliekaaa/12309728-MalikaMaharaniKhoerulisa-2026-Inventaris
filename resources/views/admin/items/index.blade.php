@extends('template')

@section('title', 'Daftar Items')
@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Items List</h4>
        <p class="text-muted small mb-0">Manage inventory item data</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('items.export') }}"
            class="btn text-white px-3" style="background-color: #6f42c1;">
            Export Excel
        </a>
        <a href="{{ route('items.create') }}" class="btn btn-green">
            <i class="bi bi-plus-lg me-1"></i> Add Item
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Repair</th>
                        <th class="text-center">Lending</th>
                        <th class="text-center" style="width:130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                    <tr>
                        <td class="text-muted">{{ $index + 1 }}</td>
                        <td>
                            {{-- @dd($items) --}}
                            <span class="badge bg-light text-dark border">
                                {{ $item->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td class="text-center">{{ $item->total_stock }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $item->repair_count > 0 ? 'warning text-dark' : 'light text-muted border' }}">
                                {{ $item->repair_count }}
                            </span>
                        </td>
                         <td class="text-center">
                            <span class="badge bg-{{ $item->lendingTotal() > 0 ? 'info text-dark' : 'light text-muted border' }}">
                               <!-- <a href="{{ route ('items.details', $item->id) }}"></a> -->
                                {{ $item->lendingTotal() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('items.edit', $item->id) }}"
                                   class="btn btn-sm btn-purple">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('items.delete', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            Belum ada data item.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
