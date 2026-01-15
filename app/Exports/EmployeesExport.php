<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::with(['department', 'position'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Email',
            'Nomor Telepon',
            'Department',
            'Position',
            'Status',
            'Tanggal Bergabung',
            'Tanggal Lahir',
            'Alamat',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->nama_lengkap,
            $employee->email,
            $employee->nomor_telepon,
            $employee->department->nama_department ?? 'N/A',
            $employee->position->nama_jabatan ?? 'N/A',
            ucfirst($employee->status),
            $employee->tanggal_masuk,
            $employee->tanggal_lahir,
            $employee->alamat,
        ];
    }
}
