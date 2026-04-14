<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'name',
        'total_stock',
        'repair_count',
        'category_id',
    ];

    /**
     * Relasi ke Categories
     */
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    /**
     * Relasi ke LendingsDetails
     */
    public function lendingsDetails()
    {
        return $this->hasMany(LendingsDetails::class, 'item_id');
    }

    /**
     * Hitung total item yang sedang dipinjam (belum dikembalikan)
     */
    public function lendingTotal()
    {
        return $this->lendingsDetails()
            ->whereHas('lendings', function ($q) {
                $q->whereNull('return_date');
            })
            ->sum('total');
    }

    /**
     * Hitung stok yang tersedia (total - dipinjam - rusak)
     */
    public function available()
    {
        $borrowed = $this->lendingTotal();
        $available = $this->total_stock - $borrowed - $this->repair_count;
        return max(0, $available);
    }
}
