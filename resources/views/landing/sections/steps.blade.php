<section id="cara-kerja" class="py-16 md:py-24 px-4 md:px-6 relative overflow-hidden bg-gradient-to-b from-white via-slate-50 to-white">
    <div class="hero-blob top-0 -right-20 opacity-10 md:opacity-20" style="z-index: 0;" aria-hidden="true"></div>
    <div class="hero-blob bottom-1/4 -left-20 opacity-10 md:opacity-20" style="z-index: 0;" aria-hidden="true"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <div class="text-center mb-12 md:mb-20">
            <div data-aos="fade-up" class="inline-block px-3 py-1 mb-4 text-[10px] font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 rounded-full">
                Panduan Cepat
            </div>
            <h2 data-aos="fade-up" data-aos-delay="50" class="text-2xl md:text-4xl font-extrabold mb-4 text-slate-900 leading-tight">
                Cara Menggunakan Aplikasi <br class="hidden md:block"> Inventaris Kami
            </h2>
            <p data-aos="fade-up" data-aos-delay="100" class="text-slate-600 text-base md:text-lg px-2 max-w-2xl mx-auto">
                Mulai digitalisasi aset Anda hanya dengan 3 langkah sederhana dan cepat untuk efisiensi maksimal.
            </p>
        </div>

        <div class="relative px-2">
            <div data-aos="fade-in" data-aos-delay="300" class="absolute left-5 sm:left-[20px] md:left-[24px] top-2 bottom-2 w-0.5 bg-gradient-to-b from-indigo-500 via-indigo-200 to-transparent hidden sm:block -translate-x-1/2" aria-hidden="true"></div>

            <ol class="space-y-12 md:space-y-20 relative">
                @foreach($steps as $index => $step)
                <li
                    data-aos="fade-up"
                    data-aos-delay="{{ ($index + 1) * 100 }}"
                    class="flex flex-col sm:flex-row gap-6 sm:gap-10 relative group">

                    <div class="flex-none w-10 h-10 md:w-12 md:h-12 bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold z-10 text-base md:text-lg shadow-xl shadow-indigo-200 ring-4 ring-white transition-all duration-300">
                        {{ $loop->iteration }}
                    </div>

                    <div class="pt-0 md:pt-1 group-hover:translate-x-1 transition-transform duration-300">
                        <h3 class="text-lg md:text-xl font-extrabold mb-3 text-slate-800 group-hover:text-indigo-600 transition-colors">
                            {{ $step['title'] }}
                        </h3>
                        <div class="relative">
                            <div class="absolute -inset-4 bg-white/40 backdrop-blur-sm rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10" aria-hidden="true"></div>
                            <p class="text-sm md:text-base text-slate-600 leading-relaxed">
                                {{ $step['description'] }}
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
