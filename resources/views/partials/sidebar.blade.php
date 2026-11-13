<aside class="sidebar">
    <a class="brand" href="{{ route('assets.index') }}">
        <span class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="m3.5 10 8.5-7 8.5 7v10.5h-17V10Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 20.5v-7h6v7M7.5 9.5h.01M16.5 9.5h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <span><strong>ruang<span>kos</span></strong><small>PROPERTY MANAGEMENT</small></span>
    </a>

    <div class="sidebar-label">MENU UTAMA</div>
    <nav class="side-nav" aria-label="Navigasi utama">
        <a class="nav-link" href="#">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 10.5 12 3l9 7.5v9a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 19.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 21v-7h8v7M7 10h.01M17 10h.01" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
            <span>Master Kamar</span>
        </a>
        <a class="nav-link" href="#">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="9" cy="8" r="3.5" stroke="currentColor" stroke-width="1.7"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 5.2a3.5 3.5 0 0 1 0 6.6M17 14a6 6 0 0 1 4.5 5.8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
            <span>Data Penghuni</span>
        </a>
        <a class="nav-link" href="#">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 4V2.5M16 4V2.5M3 9h18M8 14l2.5 2.5L16 11" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Housekeeper</span>
        </a>
        <a class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}" href="{{ route('assets.index') }}" @if (request()->routeIs('assets.*')) aria-current="page" @endif>
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 4.3 7.5-4.3M12 12v8.5" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
            <span>Inventaris Aset</span>
            <span class="nav-dot"></span>
        </a>
    </nav>

    <div class="sidebar-note">
        <span class="note-icon">✦</span>
        <strong>Kelola lebih mudah</strong>
        <p>Kelola kamar, penghuni, staf, dan aset kos dalam satu tempat.</p>
    </div>

    <div class="sidebar-bottom">
        <div class="avatar">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
        <div class="user-meta"><strong>{{ auth()->user()->name }}</strong><span>{{ auth()->user()->roleLabel() }}</span></div>
    </div>
</aside>
