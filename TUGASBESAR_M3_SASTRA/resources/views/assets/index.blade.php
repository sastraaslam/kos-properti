@extends('layouts.app')

@section('title', 'Manajemen Aset')
@section('section', 'Manajemen aset')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow"><span class="eyebrow-line"></span>KELOLA PROPERTI</div>
            <h1>Manajemen aset</h1>
            <p class="page-subtitle">Pantau dan kelola seluruh inventaris properti kos Anda.</p>
        </div>
        <a class="button button-primary" href="{{ route('assets.create') }}">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Tambah aset
        </a>
    </div>

    <section class="stats-grid" aria-label="Ringkasan aset">
        <article class="stat-card">
            <div class="stat-top"><span class="stat-icon icon-lilac"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 4.3 7.5-4.3M12 12v8.5" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span><span class="stat-trend">INVENTARIS</span></div>
            <div class="stat-number">{{ number_format($totalUnits, 0, ',', '.') }} <span>unit</span></div>
            <div class="stat-caption">Total seluruh aset terdaftar</div>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span class="stat-icon icon-mint"><svg viewBox="0 0 24 24" fill="none"><rect x="3.5" y="4" width="17" height="16" rx="2.5" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span class="stat-trend">VARIASI</span></div>
            <div class="stat-number">{{ number_format($totalCategories, 0, ',', '.') }} <span>kategori</span></div>
            <div class="stat-caption">Kategori aset yang digunakan</div>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span class="stat-icon icon-peach"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3.5v17M16.5 7.5c0-1.7-1.8-3-4.5-3S7.5 5.8 7.5 7.5 9 10 12 10s4.5 1.3 4.5 3-1.8 3.5-4.5 3.5-4.5-1.5-4.5-3.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span class="stat-trend">NILAI ASET</span></div>
            <div class="stat-number stat-currency">Rp {{ number_format((float) $totalValue, 0, ',', '.') }}</div>
            <div class="stat-caption">Estimasi nilai seluruh aset</div>
        </article>
        <article class="stat-card">
            <div class="stat-top"><span class="stat-icon icon-yellow"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3.5 21 20H3l9-16.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M12 9v4.5M12 17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span><span class="stat-trend">PERLU DICEK</span></div>
            <div class="stat-number">{{ number_format($attentionCount, 0, ',', '.') }} <span>aset</span></div>
            <div class="stat-caption">Perlu perbaikan atau rusak</div>
        </article>
    </section>

    <section class="panel asset-panel">
        <div class="panel-heading">
            <div>
                <h2>Daftar inventaris</h2>
                <p>Semua aset yang tercatat di properti Anda.</p>
            </div>
            <span class="record-count">{{ $assets->total() }} aset</span>
        </div>

        <form class="filter-bar" action="{{ route('assets.index') }}" method="GET">
            <label class="search-box">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.7"/><path d="m16 16 4.5 4.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama aset atau lokasi..." aria-label="Cari aset">
            </label>
            <label class="select-wrap">
                <span class="sr-only">Filter kategori</span>
                <select name="category">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m7 10 5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </label>
            <label class="select-wrap">
                <span class="sr-only">Filter kondisi</span>
                <select name="condition">
                    <option value="">Semua kondisi</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition }}" @selected($selectedCondition === $condition)>{{ $condition }}</option>
                    @endforeach
                </select>
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m7 10 5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </label>
            <button class="button button-filter" type="submit">Terapkan</button>
            @if ($search || $selectedCategory || $selectedCondition)
                <a class="clear-filter" href="{{ route('assets.index') }}">Reset</a>
            @endif
        </form>

        <div class="table-wrap">
            <table class="asset-table">
                <thead>
                    <tr><th>ASET</th><th>KATEGORI</th><th>LOKASI</th><th>JUMLAH</th><th>KONDISI</th><th>NILAI / UNIT</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($assets as $asset)
                        <tr>
                            <td>
                                <a class="asset-name" href="{{ route('assets.show', $asset) }}">{{ $asset->name }}</a>
                                <span class="asset-date">Ditambahkan {{ $asset->created_at->locale('id')->translatedFormat('d M Y') }}</span>
                            </td>
                            <td><span class="category-pill">{{ $asset->category }}</span></td>
                            <td><span class="location-cell"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 10c0 5-7 11-7 11S5 15 5 10a7 7 0 1 1 14 0Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="10" r="2.2" stroke="currentColor" stroke-width="1.6"/></svg>{{ $asset->location }}</span></td>
                            <td><span class="quantity-cell">{{ number_format($asset->quantity, 0, ',', '.') }} <small>unit</small></span></td>
                            <td><span class="condition-pill condition-{{ \Illuminate\Support\Str::slug($asset->asset_condition) }}"><span></span>{{ $asset->asset_condition }}</span></td>
                            <td><span class="price-cell">Rp {{ number_format((float) $asset->price, 0, ',', '.') }}</span></td>
                            <td class="action-cell">
                                <a class="icon-button" href="{{ route('assets.show', $asset) }}" aria-label="Lihat {{ $asset->name }}" title="Lihat detail">
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M2.8 12s3.2-6 9.2-6 9.2 6 9.2 6-3.2 6-9.2 6-9.2-6-9.2-6Z" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.7"/></svg>
                                </a>
                                <a class="icon-button" href="{{ route('assets.edit', $asset) }}" aria-label="Ubah {{ $asset->name }}" title="Ubah aset">
                                    <svg viewBox="0 0 24 24" fill="none"><path d="m14 5 5 5M4 20l4.2-.9L19 8.3 15.7 5 4.9 15.8 4 20Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                <form action="{{ route('assets.destroy', $asset) }}" method="POST" onsubmit="return confirm('Hapus aset ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="icon-button icon-danger" type="submit" aria-label="Hapus {{ $asset->name }}" title="Hapus aset">
                                        <svg viewBox="0 0 24 24" fill="none"><path d="M4.5 7h15M10 11v6M14 11v6M6.5 7l.8 13h9.4l.8-13M9 7V4.5h6V7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="empty-cell" colspan="7">
                            <div class="empty-state">
                                <span class="empty-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 4.3 7.5-4.3M12 12v8.5" stroke="currentColor" stroke-width="1.6"/></svg></span>
                                <strong>{{ $search || $selectedCategory || $selectedCondition ? 'Aset tidak ditemukan' : 'Belum ada aset' }}</strong>
                                <p>{{ $search || $selectedCategory || $selectedCondition ? 'Coba ubah kata kunci atau filter pencarian Anda.' : 'Mulai catat inventaris kos agar lebih mudah dipantau.' }}</p>
                                @if (! $search && ! $selectedCategory && ! $selectedCondition)
                                    <a class="button button-primary button-small" href="{{ route('assets.create') }}">Tambah aset pertama</a>
                                @endif
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($assets->hasPages())
            <div class="pagination-wrap">{{ $assets->links() }}</div>
        @endif
    </section>
@endsection
