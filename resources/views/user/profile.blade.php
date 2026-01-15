@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')

    <!-- Profile Header Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 mb-6 text-white">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Profile Photo -->
            <div class="relative group">
                <div class="w-32 h-32 rounded-full border-4 border-white shadow-xl overflow-hidden bg-white">
                    <img src="{{ $employee->photo_url }}" alt="{{ $employee->nama_lengkap }}"
                        class="w-full h-full object-cover" id="profile-photo-preview">
                </div>
                <!-- Edit Photo Button -->
                <button type="button" data-modal-target="photo-modal" data-modal-toggle="photo-modal"
                    class="absolute bottom-0 right-0 bg-white text-blue-600 rounded-full p-2 shadow-lg hover:bg-blue-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <!-- Profile Info -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-bold mb-2">{{ $employee->nama_lengkap }}</h1>
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 text-blue-100 mb-4">
                    <span class="flex items-center justify-center md:justify-start">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $employee->position->nama_jabatan ?? 'N/A' }}
                    </span>
                    <span class="flex items-center justify-center md:justify-start">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        {{ $employee->department->nama_department ?? 'N/A' }}
                    </span>
                </div>
                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $employee->email }}
                    </span>
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $employee->nomor_telepon }}
                    </span>
                    <span
                        class="px-3 py-1 bg-{{ $employee->status === 'aktif' ? 'green' : 'red' }}-500 rounded-full text-sm font-semibold">
                        {{ ucfirst($employee->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px">
                <button onclick="switchTab('info')" id="tab-info"
                    class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-blue-600 text-blue-600">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi Pribadi
                </button>
                <button onclick="switchTab('security')" id="tab-security"
                    class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Keamanan
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content: Informasi Pribadi -->
    <div id="content-info" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Data Pribadi -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Data Pribadi</h2>
                    <button type="button" data-modal-target="edit-modal" data-modal-toggle="edit-modal"
                        class="text-blue-600 hover:text-blue-700 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="flex py-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</div>
                        <div class="w-2/3 text-sm text-gray-900 dark:text-white font-medium">{{ $employee->nama_lengkap }}
                        </div>
                    </div>
                    <div class="flex py-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Email</div>
                        <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $employee->email }}</div>
                    </div>
                    <div class="flex py-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Telepon</div>
                        <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $employee->nomor_telepon }}</div>
                    </div>
                    <div class="flex py-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Lahir</div>
                        <div class="w-2/3 text-sm text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->isoFormat('D MMMM YYYY') }}
                            <span class="text-gray-500 ml-2">({{ \Carbon\Carbon::parse($employee->tanggal_lahir)->age }}
                                tahun)</span>
                        </div>
                    </div>
                    <div class="flex py-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-1/3 text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</div>
                        <div class="w-2/3 text-sm text-gray-900 dark:text-white">{{ $employee->alamat }}</div>
                    </div>
                </div>
            </div>

            <!-- Data Pekerjaan -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Data Pekerjaan</h2>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Departemen</div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $employee->department->nama_department ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Jabatan</div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $employee->position->nama_jabatan ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tanggal Bergabung</div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($employee->tanggal_masuk)->isoFormat('D MMMM YYYY') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ \Carbon\Carbon::parse($employee->tanggal_masuk)->diffForHumans() }}
                        </div>
                    </div>

                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</div>
                        <div class="text-sm font-semibold">
                            <span
                                class="px-3 py-1 bg-{{ $employee->status === 'aktif' ? 'green' : 'red' }}-500 text-white rounded-full text-xs">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content: Keamanan -->
    <div id="content-security" class="tab-content hidden">
        <div class="max-w-2xl">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Ubah Password</h2>

                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label for="current_password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Password Lama
                            </label>
                            <input type="password" name="current_password" id="current_password" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label for="new_password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Password Baru
                            </label>
                            <input type="password" name="new_password" id="new_password" required minlength="8"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimal 8 karakter</p>
                        </div>

                        <div>
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                required minlength="8"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Profile -->
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Profil
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label for="nama_lengkap"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                value="{{ $employee->nama_lengkap }}" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        </div>

                        <div>
                            <label for="nomor_telepon"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" id="nomor_telepon"
                                value="{{ $employee->nomor_telepon }}" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        </div>

                        <div>
                            <label for="alamat"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">{{ $employee->alamat }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" data-modal-hide="edit-modal"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Batal
                        </button>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Upload Photo -->
    <div id="photo-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Foto Profil
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="photo-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 md:p-5">
                    <!-- Current Photo -->
                    <div class="mb-4 text-center">
                        <img src="{{ $employee->photo_url }}" alt="Current Photo"
                            class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200 dark:border-gray-600"
                            id="modal-photo-preview">
                    </div>

                    <!-- Error/Success Messages -->
                    <div id="upload-message" class="mb-4 hidden"></div>

                    <!-- Upload Form -->
                    <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data"
                        id="photo-upload-form">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file_input">Upload Foto</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" name="foto_profile" type="file"
                                accept="image/jpeg,image/png,image/jpg" onchange="validateAndPreviewImage(event)">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" id="file-info">JPG, JPEG, atau PNG
                                (MAX. 2MB)</p>
                            <p class="mt-1 text-xs text-red-500 dark:text-red-400 hidden" id="file-error"></p>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" id="upload-btn"
                                class="flex-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed">
                                Upload
                            </button>
                        </div>
                    </form>

                    <!-- Delete Photo Form -->
                    @if ($employee->foto_profile)
                        <form action="{{ route('profile.photo.delete') }}" method="POST" class="mt-3"
                            onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full text-red-600 hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Hapus Foto
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab Switching
        function switchTab(tab) {
            // Hide all contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-600', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected content
            document.getElementById('content-' + tab).classList.remove('hidden');

            // Add active to selected button
            const activeButton = document.getElementById('tab-' + tab);
            activeButton.classList.add('active', 'border-blue-600', 'text-blue-600');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
        }

        // Validate and Preview Image before upload
        function validateAndPreviewImage(event) {
            const input = event.target;
            const preview = document.getElementById('modal-photo-preview');
            const fileError = document.getElementById('file-error');
            const fileInfo = document.getElementById('file-info');
            const uploadBtn = document.getElementById('upload-btn');
            const uploadMessage = document.getElementById('upload-message');

            // Reset
            fileError.classList.add('hidden');
            fileInfo.classList.remove('hidden');
            uploadMessage.classList.add('hidden');
            uploadBtn.disabled = false;

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = file.size / 1024 / 1024; // Convert to MB
                const fileName = file.name;
                const fileExt = fileName.split('.').pop().toLowerCase();

                // Validate file type
                const validExtensions = ['jpg', 'jpeg', 'png'];
                if (!validExtensions.includes(fileExt)) {
                    showError('Format file harus JPG, JPEG, atau PNG!');
                    input.value = '';
                    return;
                }

                // Validate file size (2MB = 2048KB)
                if (fileSize > 2) {
                    showError(`Ukuran file terlalu besar! (${fileSize.toFixed(2)}MB). Maksimal 2MB.`);
                    input.value = '';
                    return;
                }

                // Show file info
                fileInfo.innerHTML = `File: ${fileName} (${fileSize.toFixed(2)}MB) ✓`;
                fileInfo.classList.remove('text-gray-500');
                fileInfo.classList.add('text-green-600', 'dark:text-green-400');

                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }

            function showError(message) {
                fileError.textContent = message;
                fileError.classList.remove('hidden');
                fileInfo.classList.add('hidden');
                uploadBtn.disabled = true;

                // Show alert message
                uploadMessage.className =
                    'mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400';
                uploadMessage.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>
            `;
                uploadMessage.classList.remove('hidden');
            }
        }

        // Show Laravel validation errors in modal
        @if ($errors->any() && old('foto_profile') !== null)
            document.addEventListener('DOMContentLoaded', function() {
                // Open photo modal if there are upload errors
                const photoModal = document.getElementById('photo-modal');
                if (photoModal) {
                    photoModal.classList.remove('hidden');
                    photoModal.classList.add('flex');

                    // Show error message
                    const uploadMessage = document.getElementById('upload-message');
                    uploadMessage.className =
                        'mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400';
                    uploadMessage.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ $errors->first('foto_profile') }}</span>
                    </div>
                `;
                    uploadMessage.classList.remove('hidden');
                }
            });
        @endif
    </script>

@endsection
