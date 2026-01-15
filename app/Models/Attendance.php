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

    // Cast untuk memastikan format yang benar
    protected $casts = [
        'tanggal' => 'date',
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];

    /**
     * Get the employee that the attendance belongs to.
     */
    public function karyawan()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'karyawan_id');
    }
}
