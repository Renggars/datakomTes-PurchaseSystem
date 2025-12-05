<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    protected $fillable = [
        'requester_id',
        'category_id',
        'status',
        'description',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function items()
    {
        return $this->hasMany(RequestItem::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}
