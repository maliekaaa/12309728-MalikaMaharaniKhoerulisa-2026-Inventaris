<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lendings;
use App\Models\Items;
use App\Models\LendingsDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LendingsController extends Controller
{
    /**
     * Index untuk Staff – tampilkan semua lending milik user yang login
     */
    public function index()
    {
        $lendings = Lendings::with(['lendingsDetails.items', 'user'])
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        $items = Items::all();

        return view('staff.lendings.index', compact('lendings', 'items'));
    }

    /**
     * Index untuk Admin – tampilkan semua lending
     */
    public function adminIndex()
    {
        $lendings = Lendings::with(['lendingsDetails.items', 'user'])
                    ->latest()
                    ->get();

        return view('admin.lendings.index', compact('lendings'));
    }

    /**
     * Form tambah lending (untuk staff)
     */
    public function create()
    {
        $items = Items::all();

        return view('staff.lendings.create', compact('items'));
    }

    /**
     * Simpan lending baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'items'  => 'required|array|min:1',
            'totals' => 'required|array|min:1',
        ]);

        // Gunakan transaction agar jika satu gagal, semua dibatalkan
        DB::beginTransaction();

        try {
            // Validasi stok tersedia
            foreach ($request->items as $index => $itemId) {
                $item           = Items::findOrFail($itemId);
                $totalRequested = $request->totals[$index];

                if ($totalRequested <= 0) {
                    return back()->with('failed', "Jumlah item harus lebih dari 0.");
                }

                if ($totalRequested > $item->available()) {
                    return back()->with('failed', "Stok untuk item '{$item->name}' tidak mencukupi. Tersedia: {$item->available()}");
                }
            }

            // Buat record lending
            $lending = Lendings::create([
                'user_id'   => Auth::id(),
                'name'      => $request->name,
                'ket'       => $request->ket,
                'date'      => now()->toDateString(),
                'total'     => 0,
                'edited_by' => Auth::user()->name,
            ]);

            $totalAll = 0;

            // Buat detail per item
            foreach ($request->items as $index => $itemId) {
                $total = (int) $request->totals[$index];

                LendingsDetails::create([
                    'lending_id' => $lending->id,
                    'item_id'    => $itemId,
                    'total'      => $total,
                    'edited_by'  => Auth::user()->name,
                ]);

                $totalAll += $total;
            }

            // Update total di lending
            $lending->update(['total' => $totalAll]);

            DB::commit();

            return redirect()->route('lendings.index')
                             ->with('success', 'Peminjaman berhasil dicatat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Kembalikan barang (tandai return_date)
     */
    public function return($id)
    {
        $lend = Lendings::findOrFail($id);

        // Pastikan hanya pemilik atau admin yang bisa return
        if ($lend->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return back()->with('failed', 'Akses ditolak.');
        }

        if ($lend->return_date) {
            return back()->with('failed', 'Barang sudah dikembalikan sebelumnya.');
        }

        $lend->update([
            'return_date' => now()->toDateString(),
            'edited_by'   => Auth::user()->name,
        ]);

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    /**
     * Hapus lending beserta detailnya
     */
    public function destroy($id)
    {
        $lending = Lendings::findOrFail($id);

        // Cascade delete sudah diatur di DB, tapi hapus manual sebagai failsafe
        $lending->lendingsDetails()->delete();
        $lending->delete();

        return back()->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
