<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HRM System</title>
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
</head>

<body class="bg-neutral-primary min-h-screen">
    <!-- Background Pattern -->
    <div
        class="absolute inset-0 bg-gradient-to-br from-neutral-primary via-neutral-secondary-soft to-neutral-primary opacity-50">
    </div>

    <!-- Decorative Circles -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-brand opacity-10 rounded-full filter blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-fg-brand opacity-10 rounded-full filter blur-3xl"></div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-brand rounded-lg p-3 shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-heading mb-2">App Pegawai</h1>
                <p class="text-body">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Login Card -->
            <div class="bg-neutral-secondary-soft border border-default rounded-lg shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-heading mb-6 text-center">Login</h2>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-900/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-base">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-heading mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-body" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" placeholder="email@example.com"
                                class="w-full pl-10 pr-3 py-3 bg-neutral-primary border border-default text-heading rounded-base focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition"
                                value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-heading mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-body" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="w-full pl-10 pr-3 py-3 bg-neutral-primary border border-default text-heading rounded-base focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition"
                                required>
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400">
                                <!-- Eye icon or similar for show/hide -->
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 text-brand bg-neutral-primary border-default rounded focus:ring-brand focus:ring-2">
                        <label for="remember"
                            class="ml-2 text-sm text-body hover:text-heading transition cursor-pointer">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-brand hover:bg-fg-brand text-white font-semibold py-3 rounded-base transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 focus:ring-offset-neutral-secondary-soft shadow-lg hover:shadow-xl">
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-default"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-neutral-secondary-soft text-body">Informasi</span>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-body">
                        <span class="font-semibold text-heading">Demo Credentials:</span><br>
                        <span class="text-fg-brand">Admin:</span> admin@example.com / password123<br>
                        <span class="text-green-400">User:</span> user@example.com / password123
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-body">
                    © {{ date('Y') }} HRM System. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
<script>
        document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Optionally, change the icon to reflect visibility
            // This would involve changing the SVG path or using different icons
        });
    });
</script>

</html>
