<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemsController extends Controller
{
    public function index()
    {
        // Eager load relasi 'category'
        $items = Items::with('category')->withCount('lendingsDetails')->get();


        return view('admin.items.index', compact('items'));
    }

    public function details($id)
    {
        $item = Items::with('lendingsDetails.lendings.user')->findOrFail($id);

        return view('admin.items.details', compact('item'));
    }

    // untuk halaman staff, tampilkan semua item tanpa tombol aksi
    public function staffIndex()
    {
        $items = Items::with('category')->get();

        return view('staff.items.index', compact('items'));
    }

    // form tambah item baru
    public function create()
    {
        $categories = Categories::all();

        return view('admin.items.create', compact('categories'));
    }

    // untuk simpan item baru
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'total_stock' => 'required|integer|min:0',
            'category_id' => 'required',
            'repair_count'=> 'nullable|integer|min:0',
        ]);

        Items::create([
            'name'         => $request->name,
            'total_stock'  => $request->total_stock,
            'category_id'  => $request->category_id,
            'repair_count' => $request->repair_count ?? 0,
        ]);

        return redirect()->route('items.index')
                         ->with('success', 'Item berhasil ditambahkan.');
    }

    // edit
    public function edit($id)
    {
        $items      = Items::findOrFail($id);
        $categories = Categories::all();

        return view('admin.items.edit', compact('items', 'categories'));
    }

    // update
    public function update(Request $request, $id)
    {
        $item = Items::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'total_stock'  => 'required|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'repair_count' => 'nullable|integer|min:0',
        ]);

        $item->update([
            'name'         => $request->name,
            'total_stock'  => $request->total_stock,
            'category_id'  => $request->category_id,
            'repair_count' => $request->repair_count ?? 0,
        ]);

        return redirect()->route('items.index')
                         ->with('success', 'Item berhasil diupdate.');
    }

    // hapus
    public function destroy($id)
    {
        Items::findOrFail($id)->delete();

        return redirect()->route('items.index')
                         ->with('success', 'Item berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }

}
