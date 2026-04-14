@extends('template')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Staff Accounts Table</h4>
        <p class="text-secondary small mb-0">
            Add, delete, update
            <span class="text-danger opacity-75">.staff-accounts</span>
        </p>
        <p class="text-secondary small mb-0">
            <span class="text-danger opacity-75">p.s password</span> 4 character of email and nomor
        </p>
    </div>

    <div class="d-flex gap-2">
        <button class="btn text-white px-3" style="background-color:#6f42c1;">
            Export Excel
        </button>
        <a href="{{ route('users.create') }}"
            class="btn text-white px-3" style="background-color: #20c997">
            <i class="bi bi-plus-square-fill me-2"></i> Add
        </a>
    </div>
</div>

    <div class="card-body p-3">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 60px;">#</th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Email</th>
                    <th style="width: 220px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-start fw-semibold">{{ $user->name }}</td>
                    <td class="text-start">{{ $user->email }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <form action="{{ route('users.reset', $user->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm text-dark" style="background:#ffe251;">
                                    Reset Password
                                </button>
                            </form>
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
