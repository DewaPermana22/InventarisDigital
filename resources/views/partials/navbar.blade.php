<nav class="fixed w-full z-50 glass-card top-0" role="navigation" aria-label="Main Navigation">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <a href="/" title="Beranda InventarisDigital" class="flex items-center">
                <img class="max-w-[180px] md:max-w-60 h-auto"
                    src="{{ asset('logo/inventarisdg_light.svg') }}"
                    alt="Logo InventarisDigital - Solusi Manajemen Stok Barang">
            </a>
        </div>

        <div class="hidden md:block">
            <ul class="flex items-center gap-8 text-sm font-medium text-slate-600">
                <li>
                    <a href="#masalah" class="hover:text-indigo-600 transition-colors py-2" title="Masalah Inventaris Manual">Masalah</a>
                </li>
                <li>
                    <a href="#fitur" class="hover:text-indigo-600 transition-colors py-2" title="Fitur Aplikasi Inventaris">Fitur</a>
                </li>
                <li>
                    <a href="#cara-kerja" class="hover:text-indigo-600 transition-colors py-2" title="Cara Menggunakan Aplikasi">Cara Kerja</a>
                </li>
                <li>
                    <a href="{{ route('pricing') }}" class="hover:text-indigo-600 transition-colors py-2" title="Paket Harga Layanan">Harga</a>
                </li>
            </ul>
        </div>

        <div class="hidden md:block">
            <a href="{{ route('pricing') }}" class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                Mulai Sekarang
            </a>
        </div>
    </div>
</nav>

<style>
    html {
        scroll-behavior: smooth;
    }

    section {
        scroll-margin-top: 5rem;
    }
</style>
