<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Items;

class Categories extends Model
{
    //
    protected $fillable = [
        'name',
        'division_pj'
    ];

    public function items()
    {
        return $this->hasMany(Items::class, 'category_id');
    }
}
