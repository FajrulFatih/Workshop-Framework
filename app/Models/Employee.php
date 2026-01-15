<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'department_id',
        'position_id',
        'status',
        'foto_profile',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_lahir' => 'date',
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

    /**
     * Get the user associated with the employee.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    
    /**
     * Get the photo URL with default avatar
     */
    public function getPhotoUrlAttribute() 
    {
        if ($this->foto_profile && Storage::disk('public')->exists($this->foto_profile)) {
            return asset('storage/' . $this->foto_profile);
        }
        
        // Default avatar menggunakan UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama_lengkap) . '&size=400&background=3B82F6&color=fff&bold=true';
    }
}
