<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = Attendance::with('karyawan')->get();
        $employees = Employee::all();
        return view('attendances.index', compact('attendances', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'nullable|date',
            'status_absensi' => 'nullable|string|max:50',
        ]);

    // tentukan tanggal untuk mendaftar (terima beberapa nama input yang mungkin atau default ke hari ini)
    $date = $validated['tanggal'] ?? date('Y-m-d');

        // Menemukan catatan kehadiran yang ada untuk karyawan dan tanggal ini
        $attendance = Attendance::where('karyawan_id', $validated['karyawan_id'])
            ->whereDate('tanggal', $date)
            ->first();

        $now = now();
        $statusInput = $validated['status_absensi'] ?? null;

        if (!$attendance) {
            // Pertama kali hari ini: buat catatan dengan waktu_masuk diatur ke sekarang
            $attendance = new Attendance();
            $attendance->karyawan_id = $validated['karyawan_id'];
            $attendance->tanggal = $date;
            $attendance->waktu_masuk = $now;
            $attendance->waktu_keluar = null;
            $attendance->status_absensi = $statusInput ?? 'hadir';
            $saved = $attendance->save();

            if ($saved) {
                return redirect()->route('attendances.index')->with('success', 'Absensi masuk tercatat pada ' . $now->format('H:i:s'));
            }
            return back()->with('error', 'Gagal mencatat absensi masuk.')->withInput();
        }

        // Tombol kedua hari ini: perbarui waktu_keluar
        $attendance->waktu_keluar = $now;
        if ($statusInput) {
            $attendance->status_absensi = $statusInput;
        }
        $saved = $attendance->save();

        if ($saved) {
            return redirect()->route('attendances.index')->with('success', 'Waktu keluar diperbarui pada ' . $now->format('H:i:s'));
        }
        return back()->with('error', 'Gagal memperbarui waktu keluar.')->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        if ($attendance->delete()) {
            return redirect()->route('attendances.index')->with('success', 'Data kehadiran berhasil dihapus!');
        } else {
            return back()->with('error', 'Gagal menghapus data kehadiran, coba lagi.');
        }
    }
}
