<?php

namespace App\Exports;

use App\Models\Lendings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;

    // Tambahkan constructor supaya bisa nerima filter dari Controller
    public function __construct($filter = 'all')
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = Lendings::with(['items', 'user'])->latest();

        switch ($this->filter) {
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;

            case 'last_week':
                // Filter 7 hari ke belakang dari awal minggu ini
                $startLastWeek = now()->subWeek()->startOfWeek();
                $endLastWeek = now()->subWeek()->endOfWeek();
                $query->whereBetween('created_at', [$startLastWeek, $endLastWeek]);
                break;

            case 'monthly':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;

            case 'last_month':
                // Filter bulan kemarin
                $lastMonth = now()->subMonth();
                $query->whereMonth('created_at', $lastMonth->month)
                    ->whereYear('created_at', $lastMonth->year);
                break;
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Borrower Name',
            'Items',
            'Total Items',
            'Notes',
            'Lending Date',
            'Return Status',
            'Handled By'
        ];
    }

    public function map($lending): array
    {
        // Karena detail barang ada banyak (looping), kita gabung jadi satu string
        $itemsDetail = $lending->lendingsDetails->map(function ($detail) {
            return $detail->item->name ?? '-';
        })->implode(', ');

        return [
            $lending->name,
            $itemsDetail,
            $lending->total,
            $lending->ket ?? '-',
            Carbon::parse($lending->date)->format('d M Y'),
            $lending->return_date
                ? 'Returned at ' . Carbon::parse($lending->return_date)->format('d M Y')
                : 'Pending',
            $lending->user->name ?? 'System'
        ];
    }
}
