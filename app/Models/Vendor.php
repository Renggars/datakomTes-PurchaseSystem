<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'contact'];

    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }
}
