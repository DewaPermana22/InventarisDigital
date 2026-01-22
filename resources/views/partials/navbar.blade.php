<nav class="fixed w-full z-50 glass-card top-0">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <img class="max-w-60 h-auto" src="{{ asset('logo/inventarisdg_light.svg') }}" alt="brandlogo">
        </div>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
            <a href="#masalah" class="hover:text-indigo-600 transition-colors">Masalah</a>
            <a href="#fitur" class="hover:text-indigo-600 transition-colors">Fitur</a>
            <a href="#cara-kerja" class="hover:text-indigo-600 transition-colors">Cara Kerja</a>
            <a href="{{ route('pricing') }}" class="hover:text-indigo-600 transition-colors">Harga</a>
        </div>
    </div>
</nav>
