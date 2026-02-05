<section class="w-full relative pt-12 -mt-1 pb-24 bg-slate-50/50 group overflow-hidden border-none shadow-none">
    <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500/15 via-violet-500/10 to-indigo-500/15 blur-3xl rounded-[2rem] -z-10"></div>

    <div class="relative max-w-5xl mx-auto">
        <div class="relative z-20 rounded-xl md:rounded-2xl border border-slate-200/60 bg-white/70 backdrop-blur-md p-2 shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden transition-all duration-500">
            <div class="flex items-center gap-1.5 px-4 py-3 border-b border-slate-100 bg-slate-50/80">
                <div class="flex gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-400/80"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400/80"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400/80"></span>
                </div>
                <div class="mx-auto bg-white/50 border border-slate-200 rounded-md h-5 w-1/2 md:w-1/3 text-[10px] flex items-center justify-center text-slate-400 italic">
                    inventarisdigital.web.id
                </div>
            </div>
            <img src="{{ asset('images/dashboard.png') }}"
                alt="Tampilan Dashboard InventarisDigital - Solusi Manajemen Stok Otomatis"
                class="w-full h-auto rounded-b-lg md:rounded-b-xl"
                loading="lazy">
        </div>

        <div class="absolute -bottom-10 -right-4 md:-right-12 z-30 w-1/2 md:w-2/3 hidden sm:block transition-all duration-700 ease-out">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-1.5 shadow-[0_30px_60px_rgba(0,0,0,0.18)] backdrop-blur-sm">
                <div class="flex items-center gap-1 px-3 py-2 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    </div>
                </div>
                <img src="{{ asset('images/monitoring-peminjaman.png') }}"
                    alt="Fitur Monitoring Peminjaman Barang Real-time Inventaris"
                    class="w-full h-auto rounded-b-lg"
                    loading="lazy">
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center gap-4 mt-20 md:mt-24">
        <span class="h-px w-12 bg-gradient-to-r from-transparent to-slate-200"></span>
        <h3 class="text-slate-400 text-[10px] md:text-xs font-bold tracking-[0.3em] uppercase">
            Antarmuka Admin InventarisDigital
        </h3>
        <span class="h-px w-12 bg-gradient-to-l from-transparent to-slate-200"></span>
    </div>
</section>
