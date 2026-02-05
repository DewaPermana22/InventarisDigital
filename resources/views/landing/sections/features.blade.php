<section id="fitur" class="py-16 md:py-24 px-4 md:px-6 relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50/50">
    <div class="hero-blob -top-20 -right-20 opacity-10 md:opacity-20" style="z-index: 0;" aria-hidden="true"></div>
    <div class="hero-blob bottom-0 -left-20 opacity-10 md:opacity-20" style="z-index: 0;" aria-hidden="true"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-12 md:mb-16">
            <div data-aos="fade-up" class="inline-block px-3 py-1 mb-4 text-[10px] font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 rounded-full">
                Eksplorasi Keunggulan
            </div>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-2xl md:text-4xl font-extrabold mb-4 text-slate-900 leading-tight">
                Fitur Aplikasi Manajemen <br class="hidden md:block"> Inventaris & Aset
            </h2>
            <p data-aos="fade-up" data-aos-delay="200" class="text-slate-600 max-w-2xl mx-auto text-base md:text-lg px-2">
                Sistem kami dirancang dengan fitur cerdas untuk mengoptimalkan efisiensi operasional dan kontrol stok harian Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($features as $index => $feature)
            <article
                data-aos="fade-up"
                data-aos-delay="{{ ($index + 1) * 100 }}"
                class="group p-8 bg-white/70 backdrop-blur-md rounded-[2rem] border border-white shadow-sm  hover:shadow-indigo-500/10 transition-all duration-500">

                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-inner group-hover:bg-indigo-500 group-hover:text-white  transition-all duration-500">
                    <i data-lucide="{{ $feature['icon'] }}" aria-hidden="true" class="w-7 h-7"></i>
                </div>

                <h3 class="text-lg font-bold mb-3 text-slate-800 group-hover:text-indigo-600 transition-colors">
                    {{ $feature['title'] }}
                </h3>

                <p class="text-sm text-slate-500 leading-relaxed">
                    {{ $feature['description'] }}
                </p>

                <div class="w-0 group-hover:w-full h-1 bg-indigo-600/20 mt-6 rounded-full transition-all duration-500"></div>
            </article>
            @endforeach
        </div>
    </div>
</section>
