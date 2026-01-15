<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pegawai')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'neutral-primary': '#1F2937',
                        'neutral-secondary-soft': '#374151',
                        'neutral-tertiary': '#4B5563',
                        'default': '#6B7280',
                        'heading': '#F9FAFB',
                        'body': '#D1D5DB',
                        'brand': '#3B82F6',
                        'fg-brand': '#60A5FA',
                    },
                    borderRadius: {
                        'base': '0.5rem',
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-neutral-primary fixed w-full z-20 top-0 start-0 border-b border-default">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <svg class="h-7 w-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">App Pegawai</span>
            </a>

            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>

            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="block py-2 px-3 {{ request()->routeIs('dashboard') ? 'text-white bg-brand md:text-fg-brand md:bg-transparent' : 'text-heading hover:bg-neutral-tertiary md:hover:bg-transparent md:hover:text-fg-brand' }} rounded md:border-0 md:p-0">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('attendances.index') }}"
                            class="block py-2 px-3 {{ request()->routeIs('attendances.*') ? 'text-white bg-brand md:text-fg-brand md:bg-transparent' : 'text-heading hover:bg-neutral-tertiary md:hover:bg-transparent md:hover:text-fg-brand' }} rounded md:border-0 md:p-0">
                            Absensi Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.show') }}"
                            class="block py-2 px-3 {{ request()->routeIs('profile.*') ? 'text-white bg-brand md:text-fg-brand md:bg-transparent' : 'text-heading hover:bg-neutral-tertiary md:hover:bg-transparent md:hover:text-fg-brand' }} rounded md:border-0 md:p-0">
                            Profil
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left py-2 px-3 text-red-400 rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-red-500 md:p-0">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 px-4 mx-auto max-w-screen-xl">
        <!-- Welcome Section -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 text-white">
                <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-blue-100">{{ Auth::user()->employee?->position?->nama_jabatan ?? 'Pegawai' }} -
                    {{ Auth::user()->employee?->department?->nama_department ?? 'Department' }}</p>
                <p class="text-sm text-blue-200 mt-2">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 flex items-center"
                role="alert">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 flex items-center"
                role="alert">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any() && !request()->routeIs('profile.*'))
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Terdapat kesalahan:</span>
                </div>
                <ul class="list-disc list-inside ml-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Content -->
        <div class="mb-6">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-neutral-primary border-t border-default mt-12">
        <div class="max-w-screen-xl mx-auto p-6">
            <div class="text-center">
                <p class="text-body text-sm">© {{ date('Y') }} HRM System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>

</html>
