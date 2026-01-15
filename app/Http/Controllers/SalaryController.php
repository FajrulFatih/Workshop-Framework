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
            'bulan' => 'required|string', // Format: "2025-12" atau "December 2025"
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

        // Standarisasi format bulan ke YYYY-MM
        $bulanFormatted = $this->formatBulan($data['bulan']);

        $salary = Salary::create([
            'karyawan_id' => $data['karyawan_id'],
            'gaji_pokok' => $gajiPokok,
            'bulan' => $bulanFormatted, // Simpan dalam format YYYY-MM
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
     * Format bulan ke standar YYYY-MM
     */
    private function formatBulan($bulan)
    {
        // Jika sudah format YYYY-MM, return as is
        if (preg_match('/^\d{4}-\d{2}$/', $bulan)) {
            return $bulan;
        }

        // Jika format "November", "December", dll
        $monthMap = [
            'january' => '01',
            'januari' => '01',
            'february' => '02',
            'februari' => '02',
            'march' => '03',
            'maret' => '03',
            'april' => '04',
            'may' => '05',
            'mei' => '05',
            'june' => '06',
            'juni' => '06',
            'july' => '07',
            'juli' => '07',
            'august' => '08',
            'agustus' => '08',
            'september' => '09',
            'october' => '10',
            'oktober' => '10',
            'november' => '11',
            'december' => '12',
            'desember' => '12',
        ];

        $bulanLower = strtolower(trim($bulan));
        $currentYear = now()->year;

        if (isset($monthMap[$bulanLower])) {
            return $currentYear . '-' . $monthMap[$bulanLower];
        }

        // Jika format "December 2025", "Desember 2025", dll
        foreach ($monthMap as $monthName => $monthNumber) {
            if (stripos($bulan, $monthName) !== false) {
                // Extract year dari string jika ada
                preg_match('/\d{4}/', $bulan, $matches);
                $year = $matches[0] ?? $currentYear;
                return $year . '-' . $monthNumber;
            }
        }

        // Fallback: return as is
        return $bulan;
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
