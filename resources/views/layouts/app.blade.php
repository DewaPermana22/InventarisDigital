<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'InventarisDigital') | Solusi Manajemen Inventaris Modern</title>
    <meta name="description" content="@yield('meta_description', 'Kelola stok, aset, dan inventaris bisnis Anda secara real-time dengan InventarisDigital. Mudah, cepat, dan efisien.')">
    <meta name="keywords" content="manajemen inventaris, aplikasi stok barang, inventaris digital, kelola aset perusahaan">
    <meta name="author" content="InventarisDigital">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'InventarisDigital - Solusi Manajemen Inventaris Modern')">
    <meta property="og:description" content="@yield('meta_description', 'Kelola stok dan aset bisnis Anda dengan sistem inventaris modern.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'InventarisDigital - Solusi Manajemen Inventaris Modern')">
    <meta property="twitter:description" content="@yield('meta_description', 'Kelola stok dan aset bisnis Anda dengan sistem inventaris modern.')">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @include('partials.styles')
</head>

<body class="text-slate-900 continuous-gradient">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        lucide.createIcons();
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
    @stack('scripts')
</body>

</html>
