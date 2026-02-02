<section id="fitur" class="py-24 px-6 bg-slate-50/30">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900">
                Fitur Aplikasi Manajemen Inventaris & Aset
            </h2>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg">
                Sistem kami dirancang dengan fitur cerdas untuk mengoptimalkan efisiensi operasional dan kontrol stok harian Anda.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($features as $feature)
            <article class="p-6 bg-white rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 group">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i data-lucide="{{ $feature['icon'] }}" aria-hidden="true" class="w-6 h-6"></i>
                </div>

                <h3 class="text-lg font-bold mb-2 text-slate-800">
                    {{ $feature['title'] }}
                </h3>

                <p class="text-sm text-slate-500 leading-relaxed">
                    {{ $feature['description'] }}
                </p>
            </article>
            @endforeach
        </div>
    </div>
</section>
