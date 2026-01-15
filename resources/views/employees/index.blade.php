@extends('layouts.master')
@section('title', 'Daftar Pegawai')
@section('Page-title', 'Daftar Pegawai')
@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Pegawai -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Pegawai</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Pegawai Aktif -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 dark:bg-green-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pegawai Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Pegawai Non-aktif -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 dark:bg-red-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Non-aktif</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['inactive'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Pegawai Baru Bulan Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900 rounded-lg p-3">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Baru Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['newThisMonth'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    @if ($recentEmployees->count() > 0)
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <span class="font-semibold">Pegawai Terbaru:</span>
                    @foreach ($recentEmployees as $recent)
                        {{ $recent->nama_lengkap }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                    bergabung {{ $recentEmployees->first()->tanggal_masuk->diffForHumans() }}
                </p>
            </div>
        </div>
    @endif

    <!-- Filter & Actions Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('employees.index') }}" id="filter-form">
            <div class="flex flex-col lg:flex-row gap-4 mb-4">
                <!-- Search -->
                <div class="flex-1">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="Cari nama atau email...">
                    </div>
                </div>

                <!-- Department Filter -->
                <div class="w-full lg:w-48">
                    <select name="department" id="department" onchange="document.getElementById('filter-form').submit()"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Departemen</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->nama_department }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Position Filter -->
                <div class="w-full lg:w-48">
                    <select name="position" id="position" onchange="document.getElementById('filter-form').submit()"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Jabatan</option>
                        @foreach ($positions as $pos)
                            <option value="{{ $pos->id }}" {{ request('position') == $pos->id ? 'selected' : '' }}>
                                {{ $pos->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full lg:w-40">
                    <select name="status" id="status" onchange="document.getElementById('filter-form').submit()"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif
                        </option>
                    </select>
                </div>

                <!-- Sort -->
                <div class="w-full lg:w-48">
                    <select name="sort" id="sort" onchange="document.getElementById('filter-form').submit()"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="nama_lengkap" {{ request('sort') == 'nama_lengkap' ? 'selected' : '' }}>Nama A-Z
                        </option>
                        <option value="tanggal_masuk" {{ request('sort') == 'tanggal_masuk' ? 'selected' : '' }}>Tanggal
                            Bergabung
                        </option>
                        <option value="department" {{ request('sort') == 'department' ? 'selected' : '' }}>Department
                        </option>
                    </select>
                    <input type="hidden" name="order" value="{{ request('order', 'asc') }}">
                </div>
            </div>

            <!-- Advanced Filters (Collapsible) -->
            <div id="advanced-filters" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Bergabung Dari
                        </label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Sampai
                        </label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('employees.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition dark:bg-gray-700 dark:text-gray-300">
                        Reset
                    </a>
                </div>
            </div>

            <!-- Toggle Advanced Filters -->
            <button type="button" onclick="toggleAdvancedFilters()"
                class="mt-2 text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center">
                <svg id="advanced-icon" class="w-4 h-4 mr-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                <span id="advanced-text">Filter Lanjutan</span>
            </button>
        </form>

        <!-- Quick Filters -->
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('employees.index', ['quick_filter' => 'new'] + request()->except('quick_filter')) }}"
                class="px-3 py-1 text-sm rounded-full {{ request('quick_filter') == 'new' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }} transition">
                🆕 Pegawai Baru
            </a>
            <a href="{{ route('employees.index', ['quick_filter' => 'senior'] + request()->except('quick_filter')) }}"
                class="px-3 py-1 text-sm rounded-full {{ request('quick_filter') == 'senior' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }} transition">
                ⭐ Senior Staff
            </a>
            <a href="{{ route('employees.index', ['quick_filter' => 'this_month'] + request()->except('quick_filter')) }}"
                class="px-3 py-1 text-sm rounded-full {{ request('quick_filter') == 'this_month' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' }} transition">
                📅 Bulan Ini
            </a>
            @if (request()->hasAny(['quick_filter', 'search', 'department', 'position', 'status', 'date_from', 'date_to']))
                <a href="{{ route('employees.index') }}"
                    class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition">
                    ✕ Clear All
                </a>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 flex flex-wrap gap-2">
            <button type="button" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Pegawai
            </button>

            <a href="{{ route('employees.export') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Pegawai</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Departemen</th>
                        <th scope="col" class="px-6 py-3">Jabatan</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tanggal Bergabung</th>
                        <th scope="col" class="px-6 py-3">Lama Kerja</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <!-- Employee Info with Photo -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img src="{{ $employee->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->nama_lengkap) . '&size=40&background=3B82F6&color=fff' }}"
                                        alt="{{ $employee->nama_lengkap }}"
                                        class="w-10 h-10 aspect-square rounded-full object-cover mr-3 cursor-pointer"
                                        onclick="showQuickView({{ $employee->id }})">
                                    <div>
                                        <button type="button" onclick="showQuickView({{ $employee->id }})"
                                            class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition text-left">
                                            {{ $employee->nama_lengkap }}
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4">
                                <span class="text-gray-900 dark:text-gray-300">{{ $employee->email }}</span>
                            </td>

                            <!-- Department -->
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ $employee->department->nama_department ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Position -->
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                    {{ $employee->position->nama_jabatan ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $employee->status === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>

                            <!-- Join Date -->
                            <td class="px-6 py-4">
                                <span class="text-gray-900 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d M Y') }}
                                </span>
                            </td>

                            <!-- Work Duration -->
                            <td class="px-6 py-4">
                                @php
                                    $joinDate = \Carbon\Carbon::parse($employee->tanggal_masuk);
                                    $duration = $joinDate->diff(now());
                                    $years = $duration->y;
                                    $months = $duration->m;

                                    if ($years > 0) {
                                        $workDuration =
                                            $years . ' tahun' . ($months > 0 ? ' ' . $months . ' bulan' : '');
                                    } elseif ($months > 0) {
                                        $workDuration = $months . ' bulan';
                                    } else {
                                        $workDuration = $duration->d . ' hari';
                                    }
                                @endphp
                                <span class="text-gray-600 dark:text-gray-400 text-xs">
                                    {{ $workDuration }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @include('employees.show', ['employee' => $employee])

                                    @include('employees.edit', ['employee' => $employee])

                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus {{ $employee->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg font-medium mb-2">Tidak ada pegawai
                                        ditemukan</p>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm">Coba ubah filter atau tambahkan
                                        pegawai baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($employees->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Info -->
                    <div class="text-sm text-gray-700 dark:text-gray-400">
                        Menampilkan <span class="font-medium">{{ $employees->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $employees->lastItem() }}</span>
                        dari <span class="font-medium">{{ $employees->total() }}</span> pegawai
                    </div>

                    <!-- Pagination Links -->
                    <div>
                        {{ $employees->links() }}
                    </div>

                    <!-- Per Page -->
                    <div class="flex items-center gap-2">
                        <label for="per_page" class="text-sm text-gray-700 dark:text-gray-400">Per halaman:</label>
                        <select name="per_page" id="per_page" onchange="changePerPage(this.value)"
                            class="px-3 py-1 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal: Quick View Employee -->
    <div id="quick-view-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed z-50 justify-center items-center w-full md:inset-0 bg-black/50">
        <div class="relative p-4 w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Detail Pegawai
                    </h3>
                    <button type="button" onclick="closeQuickView()"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-4 md:p-5" id="quick-view-content">
                    <div class="flex justify-center items-center h-40">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Advanced Filters
        function toggleAdvancedFilters() {
            const filters = document.getElementById('advanced-filters');
            const icon = document.getElementById('advanced-icon');
            const text = document.getElementById('advanced-text');

            if (filters.classList.contains('hidden')) {
                filters.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
                text.textContent = 'Sembunyikan Filter';
            } else {
                filters.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
                text.textContent = 'Filter Lanjutan';
            }
        }

        // Change Per Page
        function changePerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            window.location.href = url.toString();
        }

        // // Show Quick View Modal
        // function showQuickView(employeeId) {
        //     const modal = document.getElementById('quick-view-modal');
        //     const content = document.getElementById('quick-view-content');

        //     // Show modal
        //     modal.classList.remove('hidden');
        //     modal.classList.add('flex');

        //     // Show loading
        //     content.innerHTML = `
        //     <div class="flex justify-center items-center h-40">
        //         <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        //     </div>
        // `;

        //     // Fetch employee data
        //     fetch(`/employees/${employeeId}`)
        //         .then(response => response.text())
        //         .then(html => {
        //             // Parse HTML and extract content
        //             const parser = new DOMParser();
        //             const doc = parser.parseFromString(html, 'text/html');
        //             const employeeData = doc.querySelector('.employee-detail-content');

        //             if (employeeData) {
        //                 content.innerHTML = employeeData.innerHTML;
        //             } else {
        //                 content.innerHTML = `
        //                 <div class="text-center py-8">
        //                     <p class="text-red-600">Gagal memuat data pegawai</p>
        //                 </div>
        //             `;
        //             }
        //         })
        //         .catch(error => {
        //             content.innerHTML = `
        //             <div class="text-center py-8">
        //                 <p class="text-red-600">Error: ${error.message}</p>
        //             </div>
        //         `;
        //         });
        // }

        // // Close Quick View Modal
        // function closeQuickView() {
        //     const modal = document.getElementById('quick-view-modal');
        //     modal.classList.add('hidden');
        //     modal.classList.remove('flex');
        // }

        // // Close modal when clicking outside
        // document.getElementById('quick-view-modal')?.addEventListener('click', function(e) {
        //     if (e.target === this) {
        //         closeQuickView();
        //     }
        // });

        // Auto-submit search after typing (debounced)
        let searchTimeout;
        document.getElementById('search')?.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 500);
        });
    </script>

@endsection
