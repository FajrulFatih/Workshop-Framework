<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'department_id',
        'position_id',
        'status',
    ];

    /**
     * Get the department that the employee belongs to.
     */
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }

    /**
     * Get the position that the employee belongs to.
     */
    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class, 'position_id');
    }
}
