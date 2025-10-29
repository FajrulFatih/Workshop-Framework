<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'status_absensi',
    ];

    /**
     * Get the employee that the attendance belongs to.
     */
    public function karyawan()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'karyawan_id');
    }
}
