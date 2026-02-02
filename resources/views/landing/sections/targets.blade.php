<section id="sektor-target" class="py-24 px-6 bg-white">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900">
            Solusi Inventaris untuk Berbagai Sektor Bisnis
        </h2>
        <p class="text-slate-600 mb-16 max-w-2xl mx-auto text-lg">
            Sistem InventarisDigital fleksibel dan telah disesuaikan dengan kebutuhan manajemen aset di berbagai instansi dan industri.
        </p>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($targets as $target)
            <article class="p-8 border border-indigo-100 rounded-3xl bg-indigo-600 hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 group">
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform">
                    <i data-lucide="{{ $target['icon'] }}" class="w-10 h-10 text-white" aria-hidden="true"></i>
                </div>

                <h3 class="text-xl font-bold mb-3 text-white">
                    {{ $target['title'] }}
                </h3>

                <p class="text-indigo-100 leading-relaxed text-sm md:text-base">
                    {{ $target['description'] }}
                </p>
            </article>
            @endforeach
        </div>
    </div>
</section>
