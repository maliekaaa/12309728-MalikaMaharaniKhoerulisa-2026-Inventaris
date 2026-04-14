@extends('template')

@section('title', 'Categories List')
@section('content')

<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Categories Tables</h4>
        <p class="text-muted small mb-0">Manage master data for inventory categories</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('category.create') }}" class="btn btn-green shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;" class="text-center">#</th>
                        <th>Category</th>
                        <th>Division Pj</th>
                        <th class="text-center">Total Items</th>
                        <th class="text-center" style="width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $category)
                    <tr>
                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $category->division_pj }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $category->items_count > 0 ? 'info text-dark' : 'light text-muted border' }}">
                                {{ $category->items_count }} item
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('category.edit', $category->id) }}"
                                   class="btn btn-sm btn-purple">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('category.delete', $category->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus kategori ini beserta seluruh item di dalamnya?')">
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
                        <td colspan="5" class="py-5 text-center text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            No category data available.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
