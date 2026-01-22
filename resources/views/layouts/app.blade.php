<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'InventarisDigital - Solusi Manajemen Inventaris Modern')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    @include('partials.styles')
</head>

<body class="text-slate-900 continuous-gradient">

    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

    <script>
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>

</html>
