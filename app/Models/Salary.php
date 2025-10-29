<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'karyawan_id',
        'gaji_pokok',
        'bulan',
        'tunjangan',
        'potongan',
        'total_gaji',
    ];

    /**
     * Get the employee that the salary belongs to.
     */
    public function karyawan()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'karyawan_id');
    }

    // Accessor to get the basic salary from the related position
    public function getGajiPokokAttribute()
    {
        // safe access in case relation is missing
        return optional(optional($this->karyawan)->position)->gaji_pokok ?? 0;
    }
}
