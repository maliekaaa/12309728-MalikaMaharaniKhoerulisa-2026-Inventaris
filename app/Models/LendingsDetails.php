<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingsDetails extends Model
{
    //
    protected $fillable = [
        'lendings_id',
        'items_id',
        'quantity',
    ];
}
