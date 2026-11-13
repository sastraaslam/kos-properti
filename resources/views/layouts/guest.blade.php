<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — RuangKos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kos.css') }}">
</head>
<body class="auth-page">
    <main class="auth-shell">
        <a class="brand auth-brand" href="{{ route('login') }}">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none"><path d="m3.5 10 8.5-7 8.5 7v10.5h-17V10Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 20.5v-7h6v7M7.5 9.5h.01M16.5 9.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <span><strong>ruang<span>kos</span></strong><small>PROPERTY MANAGEMENT</small></span>
        </a>

        <section class="auth-card">
            @if (session('success'))
                <div class="auth-success" role="status">{{ session('success') }}</div>
            @endif
            @yield('content')
        </section>

        <p class="auth-footer">© {{ now()->year }} RuangKos · Kelola kos dengan lebih tenang.</p>
    </main>
</body>
</html>
