@extends('template')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold">Lending Table</h5>
        <small class="text-muted">
            Data of <span class="text-danger">.lendings</span>
        </small>
    </div>
    <a href="#" class="btn btn-secondary">Back</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Name</th>
                    <th>Ket.</th>
                    <th>Date</th>
                    <th>Returned</th>
                    <th>Edited By</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-muted">{{ $index + 1 }}</td>
                    <td>{{ $items->name }}</td>
                    <td>{{ $items->total }}</td>
                    <td>{{ auth()->user()->name }}</td>
                    <td>{{ $items->description }}</td>
                    <td>{{ $lendings->date }}</td>
                    <td>{{ $retur }}</td>
                    <td>
                        <span class="badge border border-warning text-warning bg-light">
                            not returned
                        </span>
                    </td>
                    <td class="fw-bold text-primary">
                        operator wikrama
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
