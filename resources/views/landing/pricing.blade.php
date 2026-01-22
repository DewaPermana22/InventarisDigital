<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harga - InventarisDigital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            scroll-behavior: smooth;
        }

        .continuous-gradient {
            background: linear-gradient(180deg,
                    #f5f3ff 0%,
                    #ffffff 20%,
                    #ffffff 80%,
                    #f5f3ff 100%);
        }

        .pricing-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .pricing-card:hover {
            transform: translateY(-10px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }
    </style>
</head>

<body class="text-slate-900 continuous-gradient min-h-screen">

    <!-- Navbar Minimalis -->
    <nav class="fixed w-full z-50 glass-card top-0">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <a href="/" class="flex items-center gap-2">
                    <img class="max-w-60 h-auto" src="{{ asset('logo/inventarisdg_light.svg') }}" alt="brandlogo">
                </a>
            </div>
            <a href="/" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1">
                <i data-lucide="chevron-left" class="w-4 h-4"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Pricing Content -->
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1.5 mb-4 text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 rounded-full">
                    Pilihan Paket Harga
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6">Pilih Paket yang Sesuai <br>dengan <span class="text-indigo-600">Kebutuhan Anda</span></h1>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Investasi cerdas untuk efisiensi aset jangka panjang. Mulai dari yang gratis hingga fitur tanpa batas.</p>
            </div>

            <!-- Pricing Grid -->
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">

                <!-- Starter Plan -->
                <div class="pricing-card p-8 bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/50 flex flex-col">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Starter</h3>
                        <p class="text-sm text-slate-500 mb-6">Cocok untuk organisasi kecil atau tim baru.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-slate-900">Gratis</span>
                            <span class="text-slate-400 text-sm">/selamanya</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Maksimal 50 Barang
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> 1 Akun Administrator
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Riwayat Peminjaman Dasar
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <i data-lucide="minus" class="w-5 h-5"></i> Laporan Custom (PDF/Excel)
                        </li>
                    </ul>

                    <button class="w-full py-4 px-6 border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 hover:border-slate-300 transition-all">
                        Mulai Sekarang
                    </button>
                </div>

                <!-- Pro Plan -->
                <div class="pricing-card p-8 bg-white rounded-3xl border-2 border-indigo-500 shadow-2xl shadow-indigo-100 flex flex-col relative scale-105 z-10">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest px-4 py-1 rounded-full">
                        Terpopuler
                    </div>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Professional</h3>
                        <p class="text-sm text-slate-500 mb-6">Untuk instansi yang butuh kontrol penuh.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-sm font-bold text-slate-900">Rp</span>
                            <span class="text-4xl font-extrabold text-slate-900">149k</span>
                            <span class="text-slate-400 text-sm">/bulan</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3 text-slate-700 font-medium">
                            <i data-lucide="check" class="w-5 h-5 text-indigo-600"></i> Barang Tak Terbatas
                        </li>
                        <li class="flex items-center gap-3 text-slate-700 font-medium">
                            <i data-lucide="check" class="w-5 h-5 text-indigo-600"></i> Multi-Admin (Hingga 5)
                        </li>
                        <li class="flex items-center gap-3 text-slate-700 font-medium">
                            <i data-lucide="check" class="w-5 h-5 text-indigo-600"></i> Laporan Lanjutan & Statistik
                        </li>
                        <li class="flex items-center gap-3 text-slate-700 font-medium">
                            <i data-lucide="check" class="w-5 h-5 text-indigo-600"></i> Notifikasi Email & WhatsApp
                        </li>
                    </ul>

                    <button class="w-full py-4 px-6 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        Pilih Paket Pro
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="pricing-card p-8 bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/50 flex flex-col">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Enterprise</h3>
                        <p class="text-sm text-slate-500 mb-6">Solusi kustom untuk skala besar.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-extrabold text-slate-900">Custom</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Semua Fitur Pro
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Integrasi API Custom
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Support Prioritas 24/7
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> On-Premise (Opsional)
                        </li>
                    </ul>

                    <button class="w-full py-4 px-6 border border-slate-800 text-slate-800 font-bold rounded-2xl hover:bg-slate-900 hover:text-white transition-all">
                        Hubungi Kami
                    </button>
                </div>

            </div>

            <!-- Footer Small -->
            <div class="mt-20 text-center">
                <p class="text-slate-400 text-xs italic">Semua harga di atas sudah termasuk pemeliharaan sistem bulanan.</p>
            </div>
        </div>
    </section>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
