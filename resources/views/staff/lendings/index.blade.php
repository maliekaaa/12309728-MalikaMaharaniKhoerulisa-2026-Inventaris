@extends('template')

@section('title', 'Riwayat Peminjaman')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Lendings Table</h4>
        <p class="text-muted small mb-0">Data of lending</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('lendings.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Lending
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Returned</th>
                        <th class="text-center">Edited By</th>
                        <th class="text-center" style="width: 160px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lendings as $index => $lending)
                    <tr>
                        <td class="text-muted text-center">{{ $index + 1 }}</td>
                        <td class="text-center fw-bold">{{ $lending->total }}</td>
                        <td>
                            <ul class="list-unstyled mb-0 small">
                                @foreach($lending->lendingsDetails as $detail)
                                    <li>{{ $detail->items->name ?? '-' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="fw-semibold">
                            {{ $lending->name }}
                            @if($lending->ket)
                                <span class="d-block text-muted fw-normal small mt-1">
                                    <i class="bi bi-info-circle me-1"></i>{{ Str::limit($lending->ket, 30) }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($lending->date)->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            @if($lending->return_date)
                                <span class="badge bg-success mb-1">Dikembalikan</span>
                                <span class="d-block text-muted small">
                                    {{ \Carbon\Carbon::parse($lending->return_date)->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Kembali</span>
                            @endif
                        </td>
                        <td class="text-center text-muted small">
                            {{ $lending->user->name ?? 'System' }}
                            </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                @if(!$lending->return_date)
                                    <form action="{{ route('lendings.return', $lending->id) }}" method="POST"
                                        onsubmit="return confirm('Konfirmasi pengembalian?')">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-box-arrow-in-down"></i> Kembali
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('lendings.destroy', $lending->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
