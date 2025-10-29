<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'nama_department',
    ];

    /**
     * Get the employees that belong to the department.
     */
    public function employees()
    {
        return $this->hasMany(\App\Models\Employee::class, 'department_id');
    }
}
