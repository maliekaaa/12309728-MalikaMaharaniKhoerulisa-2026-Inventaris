<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lendings extends Model
{
    //
    protected $fillable = [
        'lendings_id',
        'users_id',
        'lendings_date',
        'return_date',
    ];
}
