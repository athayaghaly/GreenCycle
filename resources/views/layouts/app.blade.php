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

    <!-- KONFIGURASI WARNA MANUAL (Agar sesuai desain kita) -->
    <!-- Kita override config tailwind breeze agar warna hijaunya sesuai prototype -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981', // Emerald 500 (Warna Utama)
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
    
    <!-- WRAPPER UTAMA (Menggunakan Alpine.js x-data untuk mobile menu) -->
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

            <!-- Menu Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>
                
                <!-- Link Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primaryDark' : 'text-slate-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
                </a>
                
                <!-- Link Data Nasabah (Hanya contoh link) -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-gray-50 hover:text-primaryDark rounded-xl font-medium transition-colors">
                    <i class="fa-solid fa-users w-5"></i> Data Nasabah
                </a>

                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Transaksi</p>

                <!-- Link Setor Sampah (Ini yang kita buat nanti) -->
                <a href="{{ route('transaction.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('transaction.*') ? 'bg-primary/10 text-primaryDark' : 'text-slate-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-scale-balanced w-5"></i> Setor Sampah
                </a>
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-gray-50 hover:text-primaryDark rounded-xl font-medium transition-colors">
                    <i class="fa-solid fa-clock-rotate-left w-5"></i> Riwayat
                </a>
            </nav>

            <!-- Logout Area -->
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors text-sm font-medium">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- ==================== KONTEN KANAN ==================== -->
        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            
            <!-- TOPBAR (Mobile Toggle & User Profile) -->
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 px-4 py-3 flex justify-between items-center sticky top-0 z-30">
                <!-- Tombol Menu Mobile -->
                <button @click="sidebarOpen = true" class="md:hidden text-slate-600 p-2 rounded-lg hover:bg-gray-100">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Judul Halaman (Desktop Only) -->
                <h2 class="hidden md:block text-xl font-bold text-slate-700">
                    {{ isset($header) ? $header : 'Dashboard' }}
                </h2>

                <!-- User Profile -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center text-primaryDark font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT AREA (SLOT) -->
            <!-- Di sinilah konten form transaksi/dashboard akan muncul -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-bgLight p-4 md:p-8">
                <!-- Flash Message (Notifikasi Sukses/Gagal) -->
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
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