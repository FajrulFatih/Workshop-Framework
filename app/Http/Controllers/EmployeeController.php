<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $employees = Employee::with(['department', 'position'])->latest()->paginate(5);
    $departments = Department::all();
    $positions = Position::all();

    return view('employees.index', compact('employees', 'departments', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'alamat'        => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id'   => 'required|exists:positions,id',
            'status'        => 'required|string|max:50',
        ]);

        $employee = Employee::create($validated);
        if ($employee) {
            return redirect()->route('employees.index')->with('success', 'Data berhasil disimpan!');
        } else {
            return back()->with('error', 'Gagal menyimpan data, coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::with(['department', 'position'])->findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'alamat'        => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id'   => 'required|exists:positions,id',
            'status'       => 'required|string|max:50',
        ]);
    $employee = Employee::with(['department', 'position'])->findOrFail($id);
        if ($employee) {
            $employee->update($request->only([
                'nama_lengkap',
                'email',
                'nomor_telepon',
                'tanggal_lahir',
                'tanggal_masuk',
                'alamat',
                'department_id',
                'position_id',
                'status',
            ]));
            return redirect()->route('employees.index')->with('success', 'Data berhasil diperbarui!');
        } else {
            return back()->with('error', 'Gagal memperbarui data, coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::with('department', 'position')->find($id);
        if ($employee) {
            $employee->delete();
            return redirect()->route
            ('employees.index')->with('success', 'Data berhasil dihapus!');
        } else {
            return back()->with('error', 'Gagal menghapus data, coba lagi.');
        }
    }
}
