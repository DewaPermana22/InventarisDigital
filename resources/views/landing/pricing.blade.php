<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Paket Harga Aplikasi Inventaris & Stok Barang | InventarisDigital</title>
    <meta name="description" content="Pilih paket harga InventarisDigital yang sesuai dengan bisnis Anda. Mulai dari paket gratis untuk tim kecil hingga solusi enterprise kustom untuk aset tak terbatas.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            scroll-behavior: smooth;
        }

        .continuous-gradient {
            background: linear-gradient(180deg, #f5f3ff 0%, #ffffff 20%, #ffffff 80%, #f5f3ff 100%);
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

        /* Tambahkan class blob agar konsisten dengan landing page */
        .hero-blob {
            position: absolute;
            width: 30rem;
            height: 30rem;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            filter: blur(60px);
            border-radius: 9999px;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>

<body class="text-slate-900 continuous-gradient min-h-screen relative overflow-x-hidden">
    <div class="hero-blob -top-20 -right-20" aria-hidden="true"></div>
    <div class="hero-blob top-1/2 -left-40" aria-hidden="true"></div>

    <nav class="fixed w-full z-50 glass-card top-0">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <a href="/" title="Kembali ke Beranda">
                    <img class="max-w-[180px] h-auto" src="{{ asset('logo/inventarisdg_light.svg') }}" alt="Logo InventarisDigital">
                </a>
            </div>
            <a href="/" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1">
                <i data-lucide="chevron-left" class="w-4 h-4"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <main class="pt-32 pb-20 px-6 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1.5 mb-4 text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 rounded-full">
                    Pilihan Paket Harga Terbaik
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6">
                    Investasi Efisiensi <br>dengan <span class="text-indigo-600">Sistem Stok Barang</span>
                </h1>
                <p class="text-slate-600 max-w-2xl mx-auto text-lg">
                    Kelola aset tanpa batas dengan struktur harga transparan. Pilih paket yang paling pas untuk skala operasional Anda.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <article class="pricing-card p-8 bg-white/60 backdrop-blur-md rounded-3xl border border-slate-100 shadow-xl flex flex-col">
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-slate-800 mb-2">Paket Starter (Gratis)</h2>
                        <p class="text-sm text-slate-500 mb-6">Cocok untuk UMKM atau organisasi kecil.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-slate-900">Rp 0</span>
                            <span class="text-slate-400 text-sm">/selamanya</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> 50 Item Barang
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> 1 Akun Admin
                        </li>
                    </ul>
                    <a href="/register?plan=starter" class="text-center w-full py-4 rounded-2xl border border-slate-200 font-bold hover:bg-slate-50 transition-all">Mulai Gratis</a>
                </article>

                <article class="pricing-card p-8 bg-white rounded-3xl border-2 border-indigo-500 shadow-2xl flex flex-col relative  z-10">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-[10px] font-black uppercase px-4 py-1 rounded-full">Rekomendasi</div>
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-slate-800 mb-2">Paket Professional</h2>
                        <p class="text-sm text-slate-500 mb-6">Kontrol penuh aset menengah.</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-slate-900">Rp 149k</span>
                            <span class="text-slate-400 text-sm">/bulan</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3 text-slate-700">
                            <i data-lucide="check" class="w-5 h-5 text-indigo-600"></i> Barang Tak Terbatas
                        </li>
                        <li class="flex items-center gap-3 text-slate-700">
                            <i data-lucide="check" class="w-5 h-5 text-indigo-600"></i> Multi-User (5 Admin)
                        </li>
                    </ul>
                    <a href="/register?plan=pro" class="text-center w-center w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200">Pilih Paket Pro</a>
                </article>

                <article class="pricing-card p-8 bg-white/60 backdrop-blur-md rounded-3xl border border-slate-100 shadow-xl flex flex-col">
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-slate-800 mb-2">Paket Enterprise</h2>
                        <p class="text-sm text-slate-500 mb-6">Kustomisasi instansi skala besar.</p>
                        <div class="text-3xl font-extrabold text-slate-900">Harga Kustom</div>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3 text-slate-600">
                            <i data-lucide="check" class="w-5 h-5 text-emerald-500"></i> Integrasi API
                        </li>
                    </ul>
                    <a href="https://wa.me/your-number" class="text-center w-full py-4 border border-slate-800 rounded-2xl font-bold hover:bg-slate-900 hover:text-white transition-all">Hubungi Sales</a>
                </article>
            </div>

            <footer class="mt-20 text-center">
                <p class="text-slate-500 text-sm">Butuh bantuan? <a href="/faq" class="text-indigo-600 underline">Lihat FAQ</a></p>
            </footer>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
