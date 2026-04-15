@extends('template')

@section('title', 'Lending History')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Lendings Table</h4>
        <p class="text-muted small mb-0">Data of lending history</p>
    </div>

    <div class="d-flex gap-2">
        <form action="{{ route('lendings.index') }}" method="GET" id="filterForm" class="d-flex gap-2">
            <select name="filter" class="form-select border-0 shadow-sm" style="width: 160px;" onchange="this.form.submit()">
                <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua Data</option>
                <option value="weekly" {{ request('filter') == 'weekly' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                <option value="monthly" {{ request('filter') == 'monthly' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
            </select>
        </form>

        <a href="{{ route('lendings.export', ['filter' => request('filter', 'all')]) }}" 
           class="btn text-white px-3 shadow-sm" 
           style="background-color: #6f42c1;">
            <i class="bi bi-file-earmark-excel me-1"></i> Export
        </a>

        <a href="{{ route('lendings.create') }}" class="btn btn-primary shadow-sm px-3">
            <i class="bi bi-plus-lg me-1"></i> Add
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Items</th>
                        <th class="text-center">Note</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Handled By</th>
                        <th class="text-center" style="width: 130px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lendings as $index => $lending)
                    <tr>
                        <td class="text-muted text-center">{{ $index + 1 }}</td>
                        <td class="fw-semibold text-center">{{ $lending->name }}</td>
                        <td class="text-center">
                            @foreach($lending->items as $item)
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary px-2 py-1 mb-1">
                                    {{ $item->name }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <small class="text-muted">{{ $lending->ket ?: '-' }}</small>
                        </td>
                        <td class="text-center fw-bold text-primary">{{ $lending->total }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($lending->date)->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            @if($lending->return_date)
                                <span class="badge bg-success-subtle text-success border border-success px-2 py-1 mb-1">Returned</span>
                            @else
                                <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">Not Returned</span>
                            @endif
                        </td>
                        <td class="text-center text-muted small">
                            {{ $lending->user->name ?? 'System' }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                @if(!$lending->return_date)
                                    <form action="{{ route('lendings.return', $lending->id) }}" method="POST" onsubmit="return confirm('Confirm return?')">
                                        @csrf
                                        <button class="btn btn-sm btn-success shadow-sm">
                                            Returned
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('lendings.destroy', $lending->id) }}" method="POST" onsubmit="return confirm('Delete record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger shadow-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center p-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            No lending data found for this period.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection