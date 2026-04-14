@extends('template')

@section('title', 'Form Peminjaman')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Peminjaman Baru</h4>
    <p class="text-muted small mb-0">Isi formulir untuk merekam data peminjaman inventaris.</p>
</div>

<div class="card p-4" style="max-width: 700px;">
    <form action="{{ route('lendings.store') }}" method="POST">
        @csrf

        {{-- Nama Kegiatan / Peminjam --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Nama Peminjam / Kegiatan <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Kegiatan Porseni" value="{{ old('name') }}" required>
        </div>

        {{-- Dynamic Items Wrapper --}}
        <h6 class="fw-bold mb-3 border-bottom pb-2">Keranjang Peminjaman</h6>
        <div id="items-wrapper">
            <div class="row mb-3 item-row align-items-end">
                <div class="col-md-6">
                    <label class="form-label small">Nama Item <span class="text-danger">*</span></label>
                    <select name="items[]" class="form-select item-select" required>
                        <option value="">Pilih Item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" data-stok="{{ $item->available() }}" {{ $item->available() <= 0 ? 'disabled' : '' }}>
                                {{ $item->name }} (Sisa: {{ $item->available() }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="totals[]" class="form-control" placeholder="0" min="1" required>
                </div>
                <div class="col-md-2 mt-2 mt-md-0">
                    <button type="button" class="btn btn-danger w-100 remove-item" disabled>
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="button" id="add-more" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Item Lain
            </button>
        </div>

        {{-- Keterangan --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Keterangan <span class="text-muted small">(opsional)</span></label>
            <textarea name="ket" class="form-control" rows="3" placeholder="Tuliskan catatan tambahan jika ada">{{ old('ket') }}</textarea>
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('lendings.index') }}" class="btn btn-light border">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send-check me-1"></i> Ajukan Peminjaman
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('items-wrapper');
        const btnAdd = document.getElementById('add-more');

        // template string, jadi kita pass list options dari server-side
        const itemOptions = `
            <option value="">Pilih Item</option>
            @foreach($items as $item)
                <option value="{{ $item->id }}" data-stok="{{ $item->available() }}" {{ $item->available() <= 0 ? 'disabled' : '' }}>
                    {{ $item->name }} (Sisa: {{ $item->available() }})
                </option>
            @endforeach
        `;

        btnAdd.addEventListener('click', function(e) {
            e.preventDefault();

            const newRow = document.createElement('div');
            newRow.className = 'row mb-3 item-row align-items-end';
            newRow.innerHTML = `
                <div class="col-md-6">
                    <select name="items[]" class="form-select item-select" required>
                        ${itemOptions}
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="totals[]" class="form-control" placeholder="0" min="1" required>
                </div>
                <div class="col-md-2 mt-2 mt-md-0">
                    <button type="button" class="btn btn-danger w-100 remove-item">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;

            wrapper.appendChild(newRow);
            updateRemoveButtons();
        });

        // Event delegation for dynamically added remove buttons
        wrapper.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-item');
            if (removeBtn) {
                const row = removeBtn.closest('.item-row');
                // Don't allow removing if it's the last row
                if (wrapper.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    updateRemoveButtons();
                }
            }
        });

        function updateRemoveButtons() {
            const rows = wrapper.querySelectorAll('.item-row');
            const btns = wrapper.querySelectorAll('.remove-item');

            // Jika hanya 1 row, disable tombol hapus
            if (rows.length === 1) {
                btns[0].disabled = true;
            } else {
                btns.forEach(btn => btn.disabled = false);
            }
        }
    });
</script>
@endpush

@endsection
