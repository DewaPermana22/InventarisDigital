<section id="masalah" class="py-24 px-6 relative bg-slate-50/50 overflow-hidden">
    <div class="hero-blob -bottom-20 -right-20" aria-hidden="true"></div>
    <div class="hero-blob top-1/2 -left-40" aria-hidden="true"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900 leading-tight">
                Masalah Manajemen Inventaris Manual yang Menghambat Bisnis
            </h2>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed">
                Hentikan kebiasaan lama yang membuat pencatatan stok barang menjadi tidak akurat dan menghambat produktivitas tim Anda.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($problems as $problem)
            <article class="p-8 glass-card rounded-3xl shadow-sm border border-slate-100 hover:border-indigo-200 transition-all duration-300 bg-white/40 backdrop-blur-sm">
                <div class="w-12 h-12 bg-{{ $problem['color'] }}-50 text-{{ $problem['color'] }}-500 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                    <i data-lucide="{{ $problem['icon'] }}" aria-hidden="true"></i>
                </div>

                <h3 class="text-xl font-bold mb-3 text-slate-800">
                    {{ $problem['title'] }}
                </h3>

                <p class="text-slate-600 leading-relaxed">
                    {{ $problem['description'] }}
                </p>
            </article>
            @endforeach
        </div>
    </div>
</section>
