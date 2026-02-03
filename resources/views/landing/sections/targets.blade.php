<section id="sektor-target" class="py-20 md:py-32 px-6 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-16 md:mb-20">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                Satu Sistem untuk <span class="text-indigo-600">Semua Sektor</span>
            </h2>
            <p class="text-slate-500 max-w-2xl mx-auto text-base md:text-lg font-medium leading-relaxed">
                Fleksibilitas InventarisDigital memungkinkan manajemen aset yang presisi, apa pun jenis industrinya.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($targets as $target)
            <article class="group p-8 md:p-10 border border-slate-100 rounded-[2.5rem] bg-slate-50/30 hover:bg-white hover:border-indigo-200 transition-all duration-300">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-500 transition-colors duration-300">
                    <i data-lucide="{{ $target['icon'] }}"
                        class="w-7 h-7 text-indigo-600 group-hover:text-white transition-colors duration-300"
                        aria-hidden="true"></i>
                </div>

                <h3 class="text-xl font-extrabold mb-4 text-slate-800 group-hover:text-indigo-600 transition-colors">
                    {{ $target['title'] }}
                </h3>

                <p class="text-slate-500 leading-relaxed text-sm md:text-base font-medium">
                    {{ $target['description'] }}
                </p>

                <div class="mt-8 flex items-center gap-2 text-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-[-10px] group-hover:translate-x-0 transition-transform">
                    <a class="text-xs cursor-pointer font-black uppercase tracking-widest">Detail Solusi</a>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
