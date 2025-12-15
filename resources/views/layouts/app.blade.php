<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GreenCycle') }}</title>

    <!-- 1. Load Font Awesome (Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- 2. Load Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- 3. Load Tailwind & Alpine via Vite (Breeze Default) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- KONFIGURASI WARNA MANUAL -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981', // Emerald 500
                        primaryDark: '#047857', // Emerald 700
                        secondary: '#f59e0b', // Amber 500
                        bgLight: '#f3f4f6', // Gray 100
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-bgLight text-slate-800">
    
    <!-- WRAPPER UTAMA -->
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <!-- ==================== SIDEBAR (KIRI) ==================== -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
            
            <!-- Logo Area -->
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-2 text-primaryDark font-bold text-2xl">
                    <i class="fa-solid fa-recycle text-3xl text-primary"></i> GreenCycle
                </div>
                <!-- Tombol Close di Mobile -->
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-red-500">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <!-- ======================================================== -->
            <!--   BAGIAN NAVIGASI (SUDAH DIBUNGKUS TRANSLATE)            -->
            <!--   Perhatikan penggunaan {{ __('Kata Kunci') }}           -->
            <!-- ======================================================== -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                
                <!-- 1. MENU UMUM -->
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">{{ __('Menu Utama') }}</p>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primaryDark' : 'text-slate-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i> {{ __('Dashboard') }}
                </a>
                
                <!-- 2. KHUSUS ADMIN -->
                @if(Auth::user()->role === 'admin')
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">{{ __('Admin Area') }}</p>

                    <!-- Menu Cek Laporan -->
                    <a href="{{ route('transaction.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('transaction.index') ? 'bg-primary/10 text-primaryDark' : 'text-slate-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-file-signature w-5"></i> {{ __('Check Request') }}
                    </a>

                    <!-- Menu Kelola Jenis Sampah -->
                    <a href="{{ route('trash-types.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('trash-types.*') ? 'bg-primary/10 text-primaryDark' : 'text-slate-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-list w-5"></i> {{ __('Waste Types') }}
                    </a>
                @endif

                <!-- 3. KHUSUS NASABAH -->
                @if(Auth::user()->role === 'nasabah')
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">{{ __('Menu Nasabah') }}</p>

                    <!-- Menu Ajukan Setor Sampah -->
                    <a href="{{ route('transaction.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('transaction.create') ? 'bg-primary/10 text-primaryDark' : 'text-slate-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-plus-circle w-5"></i> {{ __('Submit Waste') }}
                    </a>

                    <!-- Menu Riwayat Saya -->
                    <a href="{{ route('transaction.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('transaction.index') ? 'bg-primary/10 text-primaryDark' : 'text-slate-600 hover:bg-gray-50' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5"></i> {{ __('My History') }}
                    </a>
                @endif

            </nav>
            <!-- ======================================================== -->

            <!-- Logout Area -->
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors text-sm font-medium">
                        <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </aside>

        <!-- ==================== KONTEN KANAN ==================== -->
        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- TOPBAR -->
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 px-4 py-3 flex justify-between items-center sticky top-0 z-30">
                <!-- Tombol Menu Mobile -->
                <button @click="sidebarOpen = true" class="md:hidden text-slate-600 p-2 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Judul Halaman -->
                <h2 class="hidden md:block text-xl font-bold text-slate-700">
                    {{ isset($header) ? $header : 'Dashboard' }}
                </h2>

                <!-- User Profile & Language -->
                <div class="flex items-center gap-4">
                    
                    <!-- Language Switcher -->
                    <div class="flex items-center gap-1 mr-2 bg-gray-100 p-1 rounded-lg">
                        <a href="{{ route('switch.lang', 'id') }}" class="text-xs font-bold {{ app()->getLocale() == 'id' ? 'bg-white shadow text-primary' : 'text-gray-400 hover:text-gray-600' }} px-2 py-1 rounded transition-all">ID</a>
                        <a href="{{ route('switch.lang', 'en') }}" class="text-xs font-bold {{ app()->getLocale() == 'en' ? 'bg-white shadow text-primary' : 'text-gray-400 hover:text-gray-600' }} px-2 py-1 rounded transition-all">EN</a>
                    </div>

                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center text-primaryDark font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT AREA -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-bgLight p-4 md:p-8">
                <!-- Flash Message -->
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center gap-2" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center gap-2" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                            <strong class="font-bold">Gagal!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Isi Halaman -->
                {{ $slot }}
            </main>

        </div>

        <!-- Overlay Gelap untuk Mobile saat Sidebar terbuka -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 md:hidden"></div>
    </div>

</body>
</html>