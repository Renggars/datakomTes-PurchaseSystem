<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'item_name',
        'stock',
    ];

    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }
}
