<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Attendance;
use App\Models\Salary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Dasar
        $stats = [
            'totalEmployees' => Employee::count(),
            'activeEmployees' => Employee::where('status', 'aktif')->count(),
            'inactiveEmployees' => Employee::where('status', 'nonaktif')->count(),
            'totalDepartments' => Department::count(),
            'totalPositions' => Position::count(),
        ];

        // Absensi Hari Ini
        $today = now()->toDateString(); // "2025-12-17"

        $attendance = [
            'today' => Attendance::whereDate('tanggal', $today)->count(),
            'present' => Attendance::whereDate('tanggal', $today)->where('status_absensi', 'hadir')->count(),
            'izin' => Attendance::whereDate('tanggal', $today)->where('status_absensi', 'izin')->count(),
            'sakit' => Attendance::whereDate('tanggal', $today)->where('status_absensi', 'sakit')->count(),
            'alpha' => Attendance::whereDate('tanggal', $today)->where('status_absensi', 'alpha')->count(),
        ];

        // Hitung yang belum absen
        $attendance['not_absent'] = $stats['activeEmployees'] - $attendance['today'];

        // Persentase kehadiran
        $attendance['percentage'] = $stats['activeEmployees'] > 0 ? round(($attendance['present'] / $stats['activeEmployees']) * 100, 1) : 0;

        // Total Gaji Bulan Ini
        $currentMonth = now()->format('Y-m');
        $totalSalaryExpense = Salary::where('bulan', 'like', $currentMonth . '%')->sum('total_gaji');

        // Karyawan per Departemen
        $employeesByDept = Employee::select('department_id', DB::raw('count(*) as total'))->with('department')->whereNotNull('department_id')->groupBy('department_id')->get();

        // Karyawan per Jabatan
        $employeesByPosition = Employee::select('position_id', DB::raw('count(*) as total'))->with('position')->whereNotNull('position_id')->groupBy('position_id')->orderBy('total', 'desc')->get();

        // Absensi Terbaru
        $recentAttendances = Attendance::with('karyawan')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'attendance', 'totalSalaryExpense', 'employeesByDept', 'employeesByPosition', 'recentAttendances'));
    }

    public function user()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Data karyawan tidak ditemukan.');
        }

        // Stats untuk user
        $attendanceCount = Attendance::where('karyawan_id', $employee->id)->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->where('status_absensi', 'hadir')->count();

        $todayAttendance = Attendance::where('karyawan_id', $employee->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        $recentAttendances = Attendance::where('karyawan_id', $employee->id)->latest()->take(5)->get();

        return view('user.dashboard', compact('employee', 'attendanceCount', 'todayAttendance', 'recentAttendances'));
    }
}
