<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    /**
     * Tampilkan semua kategori
     */
    public function index()
    {
        $categories = Categories::withCount('items')->get();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|unique:categories,name|string|max:255',
            'division_pj' => 'required|in:Sarpras,Tata Usaha,Tefa',
        ]);

        Categories::create([
            'name'        => $request->name,
            'division_pj' => $request->division_pj,
        ]);

        return redirect()->route('category.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit kategori
     */
    public function edit($id)
    {
        $category = Categories::findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);

        $request->validate([
            'name'        => 'required|unique:categories,name,' . $id . '|string|max:255',
            'division_pj' => 'required|in:Sarpras,Tata Usaha,Tefa',
        ]);

        $category->update([
            'name'        => $request->name,
            'division_pj' => $request->division_pj,
        ]);

        return redirect()->route('category.index')
                         ->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        Categories::findOrFail($id)->delete();

        // FIX: sebelumnya redirect ke 'categories.index' (typo)
        return redirect()->route('category.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
