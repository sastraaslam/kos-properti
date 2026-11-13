<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RuangKos') — RuangKos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kos.css') }}">
</head>
<body>
    <div class="app-shell">
        @include('partials.sidebar')

        <main class="main-content">
            <header class="topbar">
                <div class="breadcrumb"><span>RuangKos</span><span class="crumb-separator">/</span><strong>@yield('section', 'Dashboard')</strong></div>
                <div class="topbar-right">
                    <span class="today">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                    <span class="topbar-divider"></span>
                    <span class="topbar-avatar" aria-label="Pengguna {{ auth()->user()->name }}">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="logout-button" type="submit">Keluar</button>
                    </form>
                </div>
            </header>

            @if (session('success'))
                <div class="flash-message" role="status">
                    <span class="flash-check">✓</span>{{ session('success') }}
                    <button type="button" class="flash-close" aria-label="Tutup notifikasi" onclick="this.parentElement.remove()">×</button>
                </div>
            @endif

            @yield('content')

            <footer class="footer">© {{ now()->year }} RuangKos <span>•</span> Kelola kos dengan lebih tenang.</footer>
        </main>
    </div>
</body>
</html>
