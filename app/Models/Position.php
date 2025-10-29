<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
    ];

    /**
     * Get the employees that belong to the position.
     */
    public function employees()
    {
        return $this->hasMany(\App\Models\Employee::class, 'position_id');
    }
}
