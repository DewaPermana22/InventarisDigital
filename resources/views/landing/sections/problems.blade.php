<section id="masalah" class="py-24 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Masih Pakai Cara Lama?</h2>
            <p class="text-slate-500">Hentikan kebiasaan yang menghambat produktivitas tim Anda.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($problems as $problem)
            <div class="p-8 glass-card rounded-2xl shadow-sm">
                <div class="w-12 h-12 bg-{{ $problem['color'] }}-50 text-{{ $problem['color'] }}-500 rounded-full flex items-center justify-center mb-6">
                    <i data-lucide="{{ $problem['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-slate-800">{{ $problem['title'] }}</h3>
                <p class="text-slate-600">{{ $problem['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
