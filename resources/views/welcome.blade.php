<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenCycle - Bank Sampah Digital</title>
    
    <!-- Load Tailwind & Alpine dari Breeze -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- CDN Tailwind (Backup agar styling aman) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981', 
                        primaryDark: '#047857',
                        secondary: '#f59e0b', 
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-600 bg-white">

    <!-- NAVBAR -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white text-xl">
                        <i class="fa-solid fa-recycle"></i>
                    </div>
                    <span class="font-bold text-xl text-slate-800 tracking-tight">GreenCycle</span>
                </div>

                <!-- Menu Login/Register -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-bold text-slate-600 hover:text-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-bold text-slate-600 hover:text-primary">Masuk</a>
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary text-white font-bold rounded-full hover:bg-primaryDark transition-all shadow-lg shadow-primary/30">
                                Daftar
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Teks Kiri -->
                <div class="text-center lg:text-left z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 text-primary text-xs font-bold uppercase tracking-wider mb-6 border border-green-100">
                        <i class="fa-solid fa-earth-asia"></i> Bank Sampah Digital
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                        Ubah Sampahmu Jadi <span class="text-primary">Rupiah</span>
                    </h1>
                    <p class="text-lg text-slate-500 mb-8 max-w-2xl mx-auto lg:mx-0">
                        Bergabunglah dengan gerakan GreenCycle. Setor sampah daur ulang, dapatkan poin, dan tukarkan dengan saldo E-Wallet atau Token Listrik.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primaryDark transition-all shadow-xl shadow-primary/30 flex items-center justify-center gap-2">
                            Mulai Sekarang <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Gambar Kanan (Ilustrasi) -->
                <div class="relative w-full lg:w-full h-full flex justify-center">
                    <div class="bg-white p-6 rounded-3xl shadow-2xl border border-gray-100 max-w-md w-full relative z-10 transform rotate-2 hover:rotate-0 transition-all duration-500">
                        <!-- Mockup Saldo -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase">Saldo Anda</p>
                                <h3 class="text-2xl font-bold text-slate-800">Rp 154.500</h3>
                            </div>
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-primary">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                        </div>
                        <!-- List Mockup -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center"><i class="fa-solid fa-bottle-water"></i></div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm text-slate-700">Botol Plastik</h4>
                                    <p class="text-xs text-slate-400">2.5 kg • Anorganik</p>
                                </div>
                                <span class="font-bold text-green-600 text-sm">+ Rp 7.500</span>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="w-10 h-10 rounded-lg bg-secondary/20 text-secondary flex items-center justify-center"><i class="fa-solid fa-box-open"></i></div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-sm text-slate-700">Kardus</h4>
                                    <p class="text-xs text-slate-400">5.0 kg • Anorganik</p>
                                </div>
                                <span class="font-bold text-green-600 text-sm">+ Rp 12.500</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-50 border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-400 text-sm">&copy; {{ date('Y') }} GreenCycle.</p>
        </div>
    </footer>

</body>
</html>