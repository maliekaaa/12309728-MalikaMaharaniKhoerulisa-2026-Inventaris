@extends('template')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="mb-3">
        <h4 class="fw-bold text-dark mb-1">Admin Accounts Table</h4>
        <p class="text-secondary small mb-0">
           add, delete, update <span class="text-danger opacity-75">.admin-accounts</span>
        </p>
        <p class="text-secondary small mb-0">
            <span class="text-danger opacity-75">.ps.password</span> 4 character of email and nomor
        </p>
    </div>


    <div class="d-flex gap-2">
        <a href="{{ route('users.export') }}"
            class="btn text-white px-3" style="background-color: #6f42c1;">
            Export Excel
        </a>
        <a href="{{ route('users.create') }}"
            class="btn text-white px-3" style="background-color: #20c997">
            <i class="bi bi-plus-square-fill me-2"></i> Add
        </a>
    </div>
</div>


    <div class="card-body p-3">
        <table class="table table-bordered align-middle text-center mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Email</th>
                    <th style="width: 180px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-start fw-semibold">{{ $user->name }}</td>
                        <td class="text-start">{{ $user->email }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-sm text-white"
                                    style="background:#6f42c1;">
                                        Edit
                                </a>
                                <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm text-white" style="background:#ff3b30;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>

@endsection
