<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Http\Request;
use App\Models\Employee;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // eager-load nested relation to avoid N+1 when accessing position->gaji_pokok in the view
        $salaries = Salary::with('karyawan.position')->get();
        $employees = Employee::with('position')->get();
        return view('salaries.index', compact('salaries', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // keep a minimal create route in case used directly
        $employees = Employee::with('position')->get();
        return view('salaries.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'gaji_pokok' => 'nullable|exists:positions,gaji_pokok',
            'bulan' => 'required|string',
            'tunjangan' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
            'total_gaji' => 'nullable|numeric',
        ]);

        $employee = Employee::with('position')->findOrFail($data['karyawan_id']);
        $gajiPokok = optional($employee->position)->gaji_pokok ?? 0;
        $tunjangan = $data['tunjangan'] ?? 0;
        $potongan = $data['potongan'] ?? 0;

        // server-side compute to avoid trusting client
        $total = $gajiPokok + $tunjangan - $potongan;

        $salary = Salary::create([
            'karyawan_id' => $data['karyawan_id'],
            'gaji_pokok' => $gajiPokok,
            'bulan' => $data['bulan'],
            'tunjangan' => $tunjangan,
            'potongan' => $potongan,
            'total_gaji' => $total,
        ]);

        if ($salary) {
            return redirect()->route('salaries.index')->with('success', 'Gaji berhasil ditambahkan.');
        }
        return back()->with('error', 'Gagal menambahkan gaji.')->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        return view('salaries.edit', compact('salary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        $data = $request->validate([
            'tunjangan' => 'nullable|numeric',
            'potongan' => 'nullable|numeric',
        ]);

        $tunjangan = $data['tunjangan'] ?? 0;
        $potongan = $data['potongan'] ?? 0;

        // server-side compute to avoid trusting client
        $total = $salary->gaji_pokok + $tunjangan - $potongan;

        $salary->tunjangan = $tunjangan;
        $salary->potongan = $potongan;
        $salary->total_gaji = $total;

        if ($salary->save()) {
            return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil diperbarui!');
        } else {
            return back()->with('error', 'Gagal memperbarui data gaji, coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        if ($salary->delete()) {
            return redirect()->route('salaries.index')->with('success', 'Data gaji berhasil dihapus!');
        } else {
            return back()->with('error', 'Gagal menghapus data gaji, coba lagi.');
        }
    }
}
