<section id="fitur" class="py-24 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Fitur Unggulan</h2>
            <p class="text-slate-500">Dirancang khusus untuk memudahkan operasional harian Anda.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($features as $feature)
            <div class="p-6 bg-white rounded-2xl hover:shadow-lg transition-all border border-slate-100">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center mb-4">
                    <i data-lucide="{{ $feature['icon'] }}"></i>
                </div>
                <h4 class="font-bold mb-2">{{ $feature['title'] }}</h4>
                <p class="text-sm text-slate-500">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
