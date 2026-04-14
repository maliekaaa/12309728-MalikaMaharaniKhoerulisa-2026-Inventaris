<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    // Menambahkan 'name', 'total_stock', 'category_id', dan 'repair_count' ke properti fillable
    protected $fillable = [
        'name',
        'total_stock',
        'category_id',
        'repair_count'
    ];

    /**
     * Relasi ke LendingsDetails
     */
    public function lendingsDetails()
    {
        return $this->hasMany(LendingsDetails::class, 'item_id');
    }

    /**
     * Relasi ke Category (Item belongs to a Category)
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    /**
     * Hitung total item yang dipinjam
     */
    public function lendingTotal()
    {
        return $this->lendingsDetails()
            ->whereHas('lendings', function ($q) {
                $q->whereNull('return_date');
            })
            ->sum('total');  // Kolom 'total' yang baru ditambahkan
    }

    public function available()
    {
        $borrowed = $this->lendingTotal();
        $available = $this->total_stock - $borrowed - $this->repair_count;
        return max(0, $available);
    }
}
