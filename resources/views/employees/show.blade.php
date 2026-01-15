{{-- @extends('layouts.master')
@section('title', 'Detail Pegawai')
@section('Page-title', 'Detail Pegawai')
@section('content')

    <!-- Wrapper for Quick View (will be extracted by JavaScript) -->
    <div class="employee-detail-content">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left: Photo & Basic Info -->
            <div class="md:w-1/3">
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg p-6 text-white text-center">
                    <img src="{{ $employee->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->nama_lengkap) . '&size=150&background=3B82F6&color=fff' }}"
                        alt="{{ $employee->nama_lengkap }}"
                        class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-white shadow-lg object-cover">

                    <h2 class="text-xl font-bold mb-1">{{ $employee->nama_lengkap }}</h2>
                    <p class="text-blue-100 text-sm mb-3">{{ $employee->position->nama_jabatan ?? 'N/A' }}</p>

                    <span
                        class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $employee->status === 'aktif' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                        {{ ucfirst($employee->status) }}
                    </span>
                </div>

                <!-- Quick Stats -->
                <div class="mt-4 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm">Informasi Cepat</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">ID:</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">#{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Lama Kerja:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                @php
                                    $joinDate = \Carbon\Carbon::parse($employee->tanggal_masuk);
                                    $diff = $joinDate->diff(now());

                                    if ($diff->y > 0) {
                                        echo $diff->y . ' tahun';
                                        if ($diff->m > 0) {
                                            echo ' ' . $diff->m . ' bulan';
                                        }
                                    } elseif ($diff->m > 0) {
                                        echo $diff->m . ' bulan';
                                    } else {
                                        echo $diff->d . ' hari';
                                    }
                                @endphp
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Usia:</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($employee->tanggal_lahir)->age }}
                                tahun</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Detailed Info -->
            <div class="md:w-2/3">
                <div class="space-y-4">
                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Kontak
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Email</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->email }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Telepon</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->nomor_telepon }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Alamat</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->alamat }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Pekerjaan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Departemen</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $employee->department->nama_department ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Jabatan</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $employee->position->nama_jabatan ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Tanggal Bergabung</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($employee->tanggal_masuk)->isoFormat('D MMMM YYYY') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Status</p>
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $employee->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Data Pribadi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Tanggal Lahir</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->isoFormat('D MMMM YYYY') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400 mb-1">Usia</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->age }} tahun</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection --}}


<!-- Modal toggle -->
<button data-modal-target="show-modal-{{ $employee->id }}" data-modal-toggle="show-modal-{{ $employee->id }}"
    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" type="button">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
</button>

<!-- Main modal -->
<div id="show-modal-{{ $employee->id }}" tabindex="-1" aria-hidden="true"
    class="hidden inset-0 fixed z-50 justify-center items-center w-full md:inset-0 bg-black/50">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Pegawai
                </h3>
                <button type="button" data-modal-hide="show-modal-{{ $employee->id }}"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Left: Photo & Basic Info -->
                    <div class="md:w-1/3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg p-6 text-white text-center">
                            <img src="{{ $employee->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->nama_lengkap) . '&size=150&background=3B82F6&color=fff' }}"
                                alt="{{ $employee->nama_lengkap }}"
                                class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-white shadow-lg object-cover">

                            <h2 class="text-xl font-bold mb-1">{{ $employee->nama_lengkap }}</h2>
                            <p class="text-blue-100 text-sm mb-3">{{ $employee->position->nama_jabatan ?? 'N/A' }}</p>

                            <span
                                class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $employee->status === 'aktif' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </div>

                        <!-- Quick Stats -->
                        <div class="mt-4 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm">Informasi Cepat</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">ID:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">#{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Lama Kerja:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">
                                        @php
                                            $joinDate = \Carbon\Carbon::parse($employee->tanggal_masuk);
                                            $diff = $joinDate->diff(now());

                                            if ($diff->y > 0) {
                                                echo $diff->y . ' tahun';
                                                if ($diff->m > 0) {
                                                    echo ' ' . $diff->m . ' bulan';
                                                }
                                            } elseif ($diff->m > 0) {
                                                echo $diff->m . ' bulan';
                                            } else {
                                                echo $diff->d . ' hari';
                                            }
                                        @endphp
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Usia:</span>
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($employee->tanggal_lahir)->age }}
                                        tahun</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Detailed Info -->
                    <div class="md:w-2/3">
                        <div class="space-y-4">
                            <!-- Contact Information -->
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Kontak
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Email</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $employee->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Telepon</p>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $employee->nomor_telepon }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Alamat</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $employee->alamat }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Information -->
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Pekerjaan
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Departemen</p>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $employee->department->nama_department ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Jabatan</p>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $employee->position->nama_jabatan ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Tanggal Bergabung</p>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($employee->tanggal_masuk)->isoFormat('D MMMM YYYY') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Status</p>
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $employee->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($employee->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div
                                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Data Pribadi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Tanggal Lahir</p>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->isoFormat('D MMMM YYYY') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 mb-1">Usia</p>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->age }} tahun</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
