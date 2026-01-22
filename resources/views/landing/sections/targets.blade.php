<section class="py-24 px-6  text-white">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 text-slate-950">Cocok Untuk Berbagai Sektor</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($targets as $target)
            <div class="p-8 border border-indigo-700 rounded-2xl bg-indigo-600 hover:bg-indigo-700 transition-colors">
                <i data-lucide="{{ $target['icon'] }}" class="w-12 h-12 mb-6 mx-auto opacity-80"></i>
                <h4 class="text-xl font-bold mb-2">{{ $target['title'] }}</h4>
                <p class="text-violet-200">{{ $target['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
