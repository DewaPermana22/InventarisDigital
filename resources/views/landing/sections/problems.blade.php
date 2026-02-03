<section id="masalah" class="py-16 md:py-24 px-4 md:px-6 relative bg-slate-50/50 overflow-hidden">
    <div class="hero-blob -bottom-20 -right-20 opacity-50 md:opacity-100" style="z-index: 0;" aria-hidden="true"></div>
    <div class="hero-blob top-1/2 -left-40 opacity-50 md:opacity-100" style="z-index: 0;" aria-hidden="true"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-12 md:mb-16 px-2">
            <h2 class="text-2xl md:text-4xl font-bold mb-4 text-slate-900 leading-tight">
                Masalah Manajemen Inventaris Manual yang Menghambat Bisnis
            </h2>
            <p class="text-slate-600 max-w-2xl mx-auto text-base md:text-lg leading-relaxed">
                Hentikan kebiasaan lama yang membuat pencatatan stok barang menjadi tidak akurat dan menghambat produktivitas tim Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            @foreach($problems as $problem)
            <article class="p-6 md:p-8 glass-card rounded-3xl shadow-sm border border-slate-100 hover:border-indigo-200 transition-all duration-300 bg-white/40 backdrop-blur-sm group">
                <div class="w-12 h-12 bg-{{ $problem['color'] }}-50 text-{{ $problem['color'] }}-500 rounded-2xl flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform">
                    <i data-lucide="{{ $problem['icon'] }}" class="w-6 h-6" aria-hidden="true"></i>
                </div>

                <h3 class="text-lg md:text-xl font-bold mb-3 text-slate-800">
                    {{ $problem['title'] }}
                </h3>

                <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                    {{ $problem['description'] }}
                </p>
            </article>
            @endforeach
        </div>
    </div>
</section>
