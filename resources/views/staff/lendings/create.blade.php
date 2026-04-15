@extends('template')

@section('title', 'Form Peminjaman')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold text-dark mb-1">Peminjaman Baru</h4>
    <p class="text-muted small mb-0">Isi formulir untuk merekam data peminjaman inventaris.</p>
</div>

<div id="alert-container"></div>

<div class="card p-4 border-0 shadow-sm" style="max-width: 700px;">
    <form action="{{ route('lendings.store') }}" method="POST" id="lending-form">
        @csrf

        {{-- Nama Peminjam --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Nama Peminjam<span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Masukkan Nama" value="{{ old('name') }}" required>
        </div>

        {{-- Dynamic Items Wrapper --}}
        <div id="items-wrapper">
            <div class="row mb-3 item-row align-items-end">
                <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted">Nama Item <span class="text-danger">*</span></label>
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
                    <label class="form-label small fw-bold text-muted">Jumlah <span class="text-danger">*</span></label>
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
            <button type="button" id="add-more" class="btn btn-outline-primary btn-sm rounded-pill">
                <i class="bi bi-plus-circle me-1"></i> Tambah Item Lain
            </button>
        </div>

        {{-- Keterangan --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Keterangan <span class="text-muted small">(opsional)</span></label>
            <textarea name="ket" class="form-control" rows="3" placeholder="Tuliskan catatan tambahan jika ada">{{ old('ket') }}</textarea>
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-end gap-2 border-top pt-4">
            <a href="{{ route('lendings.index') }}" class="btn btn-light border px-4">Batal</a>
            <button type="submit" class="btn btn-primary px-4">
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
        const form = document.getElementById('lending-form');
        const alertContainer = document.getElementById('alert-container');

        const itemOptions = `
            <option value="">Pilih Item</option>
            @foreach($items as $item)
                <option value="{{ $item->id }}" data-stok="{{ $item->available() }}" {{ $item->available() <= 0 ? 'disabled' : '' }}>
                    {{ $item->name }} (Sisa: {{ $item->available() }})
                </option>
            @endforeach
        `;

        // Fungsi Memunculkan Alert Merah (Bootstrap Style)
        function showAlert(message) {
            alertContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                        <div>
                            <strong class="d-block">Stok Tidak Mencukupi!</strong>
                            <span class="small">${message}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            // Scroll otomatis ke atas supaya alert terlihat
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Handle Submit Form (Validasi Akhir)
        form.addEventListener('submit', function(e) {
            const rows = wrapper.querySelectorAll('.item-row');
            let hasError = false;
            let errorMessage = "";

            rows.forEach((row) => {
                const select = row.querySelector('.item-select');
                const inputQty = row.querySelector('input[name="totals[]"]');
                const selectedOption = select.options[select.selectedIndex];
                
                if (selectedOption && selectedOption.value !== "") {
                    const stockAvailable = parseInt(selectedOption.getAttribute('data-stok'));
                    const requestedQty = parseInt(inputQty.value);
                    const itemName = selectedOption.text.split('(')[0].trim();

                    if (requestedQty > stockAvailable) {
                        hasError = true;
                        errorMessage += `Barang <b>${itemName}</b> hanya tersedia ${stockAvailable} unit. `;
                    }
                }
            });

            if (hasError) {
                e.preventDefault(); // Menghentikan pengiriman form
                showAlert(errorMessage);
            }
        });

        // Tambah Row Baru
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

        // Hapus Row
        wrapper.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-item');
            if (removeBtn) {
                const row = removeBtn.closest('.item-row');
                if (wrapper.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    updateRemoveButtons();
                }
            }
        });

        function updateRemoveButtons() {
            const rows = wrapper.querySelectorAll('.item-row');
            const btns = wrapper.querySelectorAll('.remove-item');
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