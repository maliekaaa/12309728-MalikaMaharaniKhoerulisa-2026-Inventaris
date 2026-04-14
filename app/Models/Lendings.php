<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lendings extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'ket',
        'total',
        'return_date',
        'edited_by',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function lendingsDetails()
    {
        return $this->hasMany(LendingsDetails::class, 'lending_id');
    }
}
