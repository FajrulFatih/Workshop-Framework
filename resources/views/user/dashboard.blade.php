@extends('layouts.user')

@section('title', 'Dashboard Pegawai')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Card 1: Kehadiran Bulan Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kehadiran Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        @php
                            $employee = Auth::user()->employee;
                            $attendanceCount = $employee
                                ? \App\Models\Attendance::where('karyawan_id', $employee->id)
                                    ->whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)
                                    ->where('status_absensi', 'hadir')
                                    ->count()
                                : 0;
                        @endphp
                        {{ $attendanceCount }} hari
                    </h3>
                </div>
            </div>
        </div>

        <!-- Card 2: Jam Kerja -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jam Kerja</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">08:00 - 17:00</h3>
                </div>
            </div>
        </div>

        <!-- Card 3: Status Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        @php
                            $todayAttendance = $employee
                                ? \App\Models\Attendance::where('karyawan_id', $employee->id)
                                    ->whereDate('tanggal', now()->toDateString())
                                    ->first()
                                : null;
                        @endphp
                        @if ($todayAttendance)
                            <span class="text-green-600">{{ ucfirst($todayAttendance->status_absensi) }}</span>
                        @else
                            <span class="text-red-600">Belum Absen</span>
                        @endif
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('attendances.index') }}"
                class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Absensi</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Catat kehadiran Anda</p>
                </div>
            </a>

            <a href="{{ route('profile.show') }}"
                class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Profil Saya</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Lihat informasi pribadi</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Riwayat Absensi Terakhir</h2>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Waktu Masuk</th>
                        <th scope="col" class="px-6 py-3">Waktu Keluar</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $recentAttendances = $employee? \App\Models\Attendance::where('karyawan_id', $employee->id)->latest()->take(5)->get(): collect();
                    @endphp
                    @forelse($recentAttendances as $attendance)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ date('d/m/Y', strtotime($attendance->tanggal)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ date('H:i', strtotime($attendance->waktu_masuk)) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $attendance->waktu_keluar ? date('H:i', strtotime($attendance->waktu_keluar)) : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $attendance->status_absensi === 'hadir'
                                    ? 'bg-green-100 text-green-800'
                                    : ($attendance->status_absensi === 'izin'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($attendance->status_absensi) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Belum ada riwayat absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
