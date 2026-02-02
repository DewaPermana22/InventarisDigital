<section id="cara-kerja" class="py-24 px-6 relative bg-white">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900">
                Cara Menggunakan Aplikasi Inventaris Kami
            </h2>
            <p class="text-slate-600 text-lg">
                Mulai digitalisasi aset Anda hanya dengan 3 langkah sederhana dan cepat.
            </p>
        </div>

        <div class="relative">
            <div class="absolute left-6 top-2 bottom-2 w-0.5 bg-indigo-100 hidden sm:block -translate-x-1/2" aria-hidden="true"></div>

            <ol class="space-y-16 relative">
                @foreach($steps as $index => $step)
                <li class="flex flex-col sm:flex-row gap-6 sm:gap-8 relative">
                    <div class="flex-none w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold z-10 text-lg shadow-xl shadow-indigo-100 ring-8 ring-white">
                        {{ $loop->iteration }}
                    </div>

                    <div class="pt-1">
                        <h3 class="text-xl font-extrabold mb-2 text-slate-800">
                            {{ $step['title'] }}
                        </h3>
                        <p class="text-slate-600 leading-relaxed italic md:not-italic">
                            {{ $step['description'] }}
                        </p>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
