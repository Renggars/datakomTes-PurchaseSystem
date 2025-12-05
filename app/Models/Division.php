<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';

    protected $fillable = [
        'name',
    ];

    /**
     * Relasi ke users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke requests melalui users
     */
    public function requests()
    {
        return $this->hasManyThrough(
            \App\Models\Request::class, // Model target
            User::class,                // Model perantara
            'division_id',              // FK di tabel users
            'requester_id',             // FK di tabel requests
            'id',                       // PK di divisions
            'id'                        // PK di users
        );
    }
}
