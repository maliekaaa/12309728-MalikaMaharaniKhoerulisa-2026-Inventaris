<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingsDetails extends Model
{
    protected $fillable = [
        'lending_id',
        'item_id',
        'qty',
        'total',
    ];

    /**
     * Relasi ke Items
     */
    public function lendings()
    {
        return $this->belongsTo(Lendings::class, 'lending_id');
    }

    public function items()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    /**
     * Hitung total berdasarkan qty dan harga item
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($lendingsDetails) {
            $item = $lendingsDetails->item;
            $lendingsDetails->total = $lendingsDetails->qty * $item->price;
        });
    }
}
