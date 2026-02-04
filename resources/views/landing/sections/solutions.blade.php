<section id="solusi" class="py-16 md:py-24 px-4 md:px-8 relative overflow-hidden bg-gradient-to-b from-white via-indigo-50/30 to-white">
    <div class="hero-blob top-1/4 -right-20 opacity-20 md:opacity-30 blur-[80px]" style="z-index: 0;" aria-hidden="true"></div>
    <div class="hero-blob -bottom-20 -left-20 opacity-20 md:opacity-30 blur-[80px]" style="z-index: 0;" aria-hidden="true"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16 mb-16 md:mb-20">

            <div class="flex-1 w-full order-2 lg:order-1 text-center lg:text-left">
                <div class="relative">
                    <div class="inline-block px-4 py-1.5 mb-6 text-[10px] font-bold tracking-[0.2em] text-indigo-600 uppercase bg-indigo-100/50 backdrop-blur-sm rounded-full lg:mx-0 mx-auto border border-indigo-200/50">
                        Teknologi Cloud Terkini
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-6 leading-[1.15] text-slate-900">
                        Solusi Digital Terbaik untuk <br class="hidden md:block">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-violet-500">Efisiensi Inventaris Anda</span>
                    </h2>
                    <p class="text-base md:text-lg text-slate-600 mb-10 leading-relaxed max-w-xl lg:mx-0 mx-auto">
                        <strong>InventarisDigital</strong> hadir untuk mengubah cara kerja manual Anda menjadi sistem cerdas yang serba otomatis dan terintegrasi.
                    </p>
                </div>

                <ul class="space-y-5 text-left inline-block lg:block">
                    @php
                    $benefits = [
                    ['title' => 'Manajemen Data Terpadu', 'desc' => 'Sinkronisasi database barang dan aset perusahaan di satu platform terpusat.'],
                    ['title' => 'Otomatisasi Stok', 'desc' => 'Status ketersediaan barang berubah secara otomatis setiap kali transaksi.'],
                    ['title' => 'Monitoring Real-Time', 'desc' => 'Pantau keluar-masuk barang kapan saja melalui dashboard cloud.']
                    ];
                    @endphp
                    @foreach($benefits as $benefit)
                    <li class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-500 transition-colors duration-300">
                            <i data-lucide="check" class="text-indigo-600 w-4 h-4 group-hover:text-white transition-colors"></i>
                        </div>
                        <span class="text-sm md:text-base text-slate-700 leading-snug">
                            <strong class="text-slate-900">{{ $benefit['title'] }}:</strong> {{ $benefit['desc'] }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex-1 w-full flex items-center justify-center relative order-1 lg:order-2">
                <div class="absolute inset-0 bg-indigo-400/20 blur-[120px] rounded-full scale-90" aria-hidden="true"></div>
                <img src="{{ asset('logo/inventory.svg') }}"
                    alt="Sistem manajemen inventaris digital otomatis berbasis cloud"
                    class="w-full max-w-[280px] sm:max-w-sm md:max-w-lg relative z-10 drop-shadow-[0_20px_50px_rgba(79,70,229,0.2)] animate-float"
                    loading="lazy">
            </div>
        </div>

        <div class="w-full relative px-2 md:px-0">
            <div class="bg-slate-900 p-2 md:p-3 rounded-[2.5rem] shadow-[0_40px_80px_-15px_rgba(0,0,0,0.1)] border border-slate-200/50 relative z-10">
                <div class="bg-white rounded-[1.8rem] overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                        <div class="flex gap-2">
                            <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                            <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                            <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                        </div>
                        <div class="hidden sm:block bg-white border border-slate-200 rounded-lg px-4 py-1.5 text-[10px] text-slate-400 font-medium">
                            app.inventarisdigital.id/admin/dashboard
                        </div>
                        <div class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100"></div>
                    </div>

                    <div class="p-8 md:p-16 min-h-[300px] md:min-h-[450px] flex items-center justify-center bg-gradient-to-br from-white to-indigo-50/30">
                        <div class="text-center max-w-md">
                            <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-8 rotate-3 shadow-2xl shadow-indigo-200">
                                <i data-lucide="layout-dashboard" class="w-10 h-10 text-white"></i>
                            </div>
                            <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">Intuitif & Modern UI</h4>
                            <p class="text-slate-500 text-sm md:text-base mb-8">
                                Pantau statistik aset, riwayat peminjaman, dan status stok dalam satu tampilan dashboard yang bersih.
                            </p>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="h-10 bg-slate-100 rounded-xl border border-slate-200/50 shadow-sm"></div>
                                <div class="h-10 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200"></div>
                                <div class="h-10 bg-slate-100 rounded-xl border border-slate-200/50 shadow-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-3 mt-8">
                <span class="h-px w-8 bg-slate-200"></span>
                <p class="text-slate-400 text-[10px] md:text-xs font-semibold tracking-widest uppercase">
                    Admin Interface Preview
                </p>
                <span class="h-px w-8 bg-slate-200"></span>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-15px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
</style>
