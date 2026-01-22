<section id="cara-kerja" class="py-24 px-6 relative">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Cara Kerja</h2>
            <p class="text-slate-500">Hanya butuh 3 langkah sederhana untuk memulai.</p>
        </div>
        <div class="space-y-16">
            @foreach($steps as $step)
            <div class="flex gap-8 relative step-item">
                <div class="flex-none w-10 h-10 bg-indigo-400 text-white rounded-full flex items-center justify-center font-bold z-10 step-line">
                    {{ $step['number'] }}
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-2">{{ $step['title'] }}</h4>
                    <p class="text-slate-600">{{ $step['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
