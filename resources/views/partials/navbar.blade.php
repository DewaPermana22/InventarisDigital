<nav class="fixed w-full z-50 glass-card top-0" role="navigation" aria-label="Main Navigation" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <a href="/" title="Beranda InventarisDigital" class="flex items-center">
                <img class="max-w-44 md:max-w-60 h-auto"
                    src="{{ asset('logo/inventarisdg_light.svg') }}"
                    alt="Logo InventarisDigital - Solusi Manajemen Stok Barang">
            </a>
        </div>

        <div class="hidden md:block">
            <ul class="flex items-center gap-8 text-sm font-medium text-slate-600">
                <li><a href="#masalah" class="hover:text-indigo-600 transition-colors py-2" title="Masalah Inventaris Manual">Masalah</a></li>
                <li><a href="#fitur" class="hover:text-indigo-600 transition-colors py-2" title="Fitur Aplikasi Inventaris">Fitur</a></li>
                <li><a href="#cara-kerja" class="hover:text-indigo-600 transition-colors py-2" title="Cara Kerja Aplikasi">Cara Kerja</a></li>
                <li><a href="#harga" class="hover:text-indigo-600 transition-colors py-2" title="Paket Harga Layanan">Harga</a></li>
            </ul>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden md:block">
                <a href="#harga" class="px-5 py-2 bg-indigo-400 text-white rounded-lg text-sm font-bold hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                    Mulai Sekarang
                </a>
            </div>

            <button @click="open = !open" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg focus:outline-none" aria-label="Toggle Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden bg-white border-t border-slate-100 shadow-xl"
        style="display: none;">
        <ul class="px-6 py-4 space-y-4 text-slate-600 font-medium">
            <li><a href="#masalah" @click="open = false" class="block py-2 hover:text-indigo-600">Masalah</a></li>
            <li><a href="#fitur" @click="open = false" class="block py-2 hover:text-indigo-600">Fitur</a></li>
            <li><a href="#cara-kerja" @click="open = false" class="block py-2 hover:text-indigo-600">Cara Kerja</a></li>
            <li><a href="#harga" class="block py-2 hover:text-indigo-600">Harga</a></li>
            <li class="pt-2">
                <a href="#harga" class="block w-full text-center px-5 py-3 bg-indigo-600 text-white rounded-lg font-bold">
                    Mulai Sekarang
                </a>
            </li>
        </ul>
    </div>
</nav>
