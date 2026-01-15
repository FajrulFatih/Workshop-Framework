<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use App\Models\Employee;

class CheckAttendanceData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check attendance data for today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $this->info("Checking attendance for: {$today}");
        $this->info('Current time: ' . now()->format('Y-m-d H:i:s'));
        $this->newLine();

        $activeEmployees = Employee::where('status', 'aktif')->count();
        $todayAttendances = Attendance::whereDate('tanggal', $today)->get();

        $this->info("Active Employees: {$activeEmployees}");
        $this->info("Today's Attendances: " . $todayAttendances->count());
        $this->newLine();

        if ($todayAttendances->count() > 0) {
            $this->table(
                ['ID', 'Employee', 'Date', 'Time In', 'Time Out', 'Status'],
                $todayAttendances->map(function ($att) {
                    return [$att->id, $att->karyawan->nama_lengkap ?? 'N/A', $att->tanggal, $att->waktu_masuk ? \Carbon\Carbon::parse($att->waktu_masuk)->format('H:i:s') : '-', $att->waktu_keluar ? \Carbon\Carbon::parse($att->waktu_keluar)->format('H:i:s') : '-', $att->status_absensi];
                }),
            );
        } else {
            $this->warn('No attendance records found for today.');
        }

        // Breakdown by status
        $this->newLine();
        $this->info('Breakdown by Status:');
        $statuses = ['hadir', 'izin', 'sakit', 'alpha'];
        foreach ($statuses as $status) {
            $count = Attendance::whereDate('tanggal', $today)->where('status_absensi', $status)->count();
            $this->line("  - {$status}: {$count}");
        }

        return 0;
    }
}
