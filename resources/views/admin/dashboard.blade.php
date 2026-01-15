@extends('layouts.master')
@section('title', 'Dashboard Admin')
@section('Page-title', 'Dashboard Admin')
@section('content')

    <!-- Welcome Banner -->
    <div class="mb-6 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-blue-100">Berikut adalah ringkasan App Pegawai Anda hari ini</p>
                <p class="text-sm text-blue-200 mt-2">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 text-blue-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        <!-- Total Karyawan -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Karyawan</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalEmployees'] }}</h3>
                    <p class="text-xs text-green-600 mt-1">{{ $stats['activeEmployees'] }} aktif</p>
                </div>
            </div>
        </div>

        <!-- Total Departemen -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Departemen</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalDepartments'] }}</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $stats['totalPositions'] }} jabatan</p>
                </div>
            </div>
        </div>

        <!-- Kehadiran Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kehadiran Hari Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $attendance['present'] }}/{{ $stats['activeEmployees'] }}
                    </h3>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xs text-green-600 dark:text-green-400">
                            {{ $attendance['percentage'] }}% hadir
                        </span>
                        @if ($attendance['not_absent'] > 0)
                            <span class="text-xs text-red-600 dark:text-red-400">
                                • {{ $attendance['not_absent'] }} belum absen
                            </span>
                        @endif
                    </div>
                </div>
            </div>

{{--             
            <!-- Detail Breakdown -->
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-4 gap-2 text-center text-xs">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Hadir</p>
                        <p class="font-bold text-green-600 dark:text-green-400">{{ $attendance['present'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Izin</p>
                        <p class="font-bold text-yellow-600 dark:text-yellow-400">{{ $attendance['izin'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Sakit</p>
                        <p class="font-bold text-orange-600 dark:text-orange-400">{{ $attendance['sakit'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Alpha</p>
                        <p class="font-bold text-red-600 dark:text-red-400">{{ $attendance['alpha'] }}</p>
                    </div>
                </div>
            </div> --}}
        </div>  

        <!-- Total Pengeluaran Gaji -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 dark:bg-yellow-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Gaji Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Rp {{ number_format($totalSalaryExpense, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ now()->format('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <!-- Karyawan per Departemen -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Karyawan per Departemen
            </h2>
            <div class="space-y-3">
                @forelse($employeesByDept as $dept)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-blue-600 mr-3"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $dept->department->nama_department ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span
                                class="text-lg font-bold text-blue-600 dark:text-blue-400 mr-2">{{ $dept->total }}</span>
                            <div class="w-24 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ $stats['totalEmployees'] > 0 ? ($dept->total / $stats['totalEmployees']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada data departemen</p>
                @endforelse
            </div>
        </div>

        <!-- Karyawan per Jabatan -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Karyawan per Jabatan
            </h2>
            <div class="space-y-3">
                @forelse($employeesByPosition as $pos)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-green-600 mr-3"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $pos->position->nama_jabatan ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span
                                class="text-lg font-bold text-green-600 dark:text-green-400 mr-2">{{ $pos->total }}</span>
                            <div class="w-24 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full"
                                    style="width: {{ $stats['totalEmployees'] > 0 ? ($pos->total / $stats['totalEmployees']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-4">Belum ada data jabatan</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Links -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Absensi Terbaru -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Absensi Terbaru
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Nama</th>
                            <th scope="col" class="px-4 py-3">Tanggal</th>
                            <th scope="col" class="px-4 py-3">Waktu Masuk</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAttendances as $attendance)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    {{ $attendance->karyawan->nama_lengkap ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">{{ date('d/m/Y', strtotime($attendance->tanggal)) }}</td>
                                <td class="px-4 py-3">{{ date('H:i', strtotime($attendance->waktu_masuk)) }}</td>
                                <td class="px-4 py-3">
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
                                <td colspan="4" class="px-4 py-3 text-center">Belum ada data absensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="{{ route('employees.index') }}"
                    class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Kelola Karyawan</h3>
                    </div>
                </a>

                <a href="{{ route('attendances.index') }}"
                    class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Kelola Absensi</h3>
                    </div>
                </a>

                <a href="{{ route('salaries.index') }}"
                    class="flex items-center p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Kelola Gaji</h3>
                    </div>
                </a>

                <a href="{{ route('departments.index') }}"
                    class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Kelola Departemen</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection
