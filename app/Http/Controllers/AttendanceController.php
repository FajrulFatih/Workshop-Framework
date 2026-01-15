<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // Jika admin, tampilkan semua attendance
        if ($user->role === 'admin') {
            $attendances = Attendance::with('karyawan')->latest()->get();
            $employees = Employee::all();
        } else {
            // Jika user biasa, hanya tampilkan attendance milik sendiri
            $employee = $user->employee;

            if (!$employee) {
                return redirect()->route('dashboard')->with('error', 'Data karyawan tidak ditemukan.');
            }

            $attendances = Attendance::with('karyawan')->where('karyawan_id', $employee->id)->latest()->get();
            $employees = Employee::where('id', $employee->id)->get(); // Hanya employee sendiri
        }

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
        $user = Auth::user();

        // Jika user biasa, paksa karyawan_id ke employee sendiri
        if (!$user->role === 'admin') {
            $employee = $user->employee;
            if (!$employee) {
                return back()->with('error', 'Data karyawan tidak ditemukan.');
            }
            $request->merge(['karyawan_id' => $employee->id]);
        }

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'nullable|date',
            'status_absensi' => 'nullable|string|max:50',
        ]);

        // Tentukan tanggal - PERBAIKAN: pastikan format date
        $date = isset($validated['tanggal']) ? \Carbon\Carbon::parse($validated['tanggal'])->toDateString() : now()->toDateString();

        // Cek apakah sudah ada attendance untuk karyawan ini hari ini
        $attendance = Attendance::where('karyawan_id', $validated['karyawan_id'])->whereDate('tanggal', $date)->first();

        $now = now();
        $statusInput = $validated['status_absensi'] ?? 'hadir';

        if (!$attendance) {
            // Pertama kali hari ini: buat catatan dengan waktu_masuk
            $attendance = Attendance::create([
                'karyawan_id' => $validated['karyawan_id'],
                'tanggal' => $date,
                'waktu_masuk' => $now,
                'waktu_keluar' => null,
                'status_absensi' => $statusInput,
            ]);

            return redirect()
                ->route('attendances.index')
                ->with('success', 'Absensi masuk tercatat pada ' . $now->format('H:i:s'));
        }

        // Sudah ada record - update waktu keluar
        $attendance->update([
            'waktu_keluar' => $now,
            'status_absensi' => $statusInput,
        ]);

        return redirect()
            ->route('attendances.index')
            ->with('success', 'Waktu keluar diperbarui pada ' . $now->format('H:i:s'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        $user = Auth::user();

        // User hanya bisa lihat attendance sendiri
        if (!$user->role === 'admin' && $attendance->karyawan_id !== $user->employee->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('attendances.show', compact('attendance'));
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
        // Hanya admin yang bisa delete
        if (!Auth::user()->role === 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($attendance->delete()) {
            return redirect()->route('attendances.index')->with('success', 'Data kehadiran berhasil dihapus!');
        } else {
            return back()->with('error', 'Gagal menghapus data kehadiran, coba lagi.');
        }
    }
}
