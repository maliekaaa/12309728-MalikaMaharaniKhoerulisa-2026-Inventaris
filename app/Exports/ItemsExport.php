<?php

namespace App\Exports;

use App\Models\Items;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Items::with('category')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total',
            'Repair Total',
            'Last Updated',
        ];
    }

    /**
    * Menerjemahkan data row Excel dengan aturan khusus (seperti 0 menjadi -)
    *
    * @var Items $item
    * @return array
    */
    public function map($item): array
    {
        return [
            $item->category->name ?? '-',
            $item->name,
            $item->total,
            $item->repair == 0 ? '-' : $item->repair,
            $item->updated_at->format('M j, Y')
        ];
    }
}
