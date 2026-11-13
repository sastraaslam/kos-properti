@extends('layouts.app')

@section('title', $asset->name)
@section('section', 'Detail aset')

@section('content')
    <div class="page-heading">
        <div>
            <a class="back-link" href="{{ route('assets.index') }}">← Kembali ke daftar aset</a>
            <div class="eyebrow"><span class="eyebrow-line"></span>DETAIL INVENTARIS</div>
            <h1>{{ $asset->name }}</h1>
            <p class="page-subtitle">Informasi lengkap aset yang tercatat di properti Anda.</p>
        </div>
        <a class="button button-primary" href="{{ route('assets.edit', $asset) }}">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m14 5 5 5M4 20l4.2-.9L19 8.3 15.7 5 4.9 15.8 4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Ubah aset
        </a>
    </div>

    <section class="panel detail-panel">
        <div class="detail-hero">
            <span class="detail-asset-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 4.3 7.5-4.3M12 12v8.5" stroke="currentColor" stroke-width="1.7"/></svg></span>
            <div><span class="category-pill">{{ $asset->category }}</span><h2>{{ $asset->name }}</h2><p>Ditambahkan {{ $asset->created_at->locale('id')->translatedFormat('d F Y') }}</p></div>
            <span class="condition-pill condition-{{ \Illuminate\Support\Str::slug($asset->asset_condition) }}"><span></span>{{ $asset->asset_condition }}</span>
        </div>
        <div class="detail-grid">
            <div class="detail-item"><span>LOKASI / KAMAR</span><strong>{{ $asset->location }}</strong></div>
            <div class="detail-item"><span>JUMLAH</span><strong>{{ number_format($asset->quantity, 0, ',', '.') }} unit</strong></div>
            <div class="detail-item"><span>STATUS PENGGUNAAN</span><strong>{{ $asset->status }}</strong></div>
            <div class="detail-item"><span>TANGGAL PEMBELIAN</span><strong>{{ $asset->purchase_date?->locale('id')->translatedFormat('d F Y') ?? '—' }}</strong></div>
            <div class="detail-item"><span>HARGA PER UNIT</span><strong>Rp {{ number_format((float) $asset->price, 0, ',', '.') }}</strong></div>
            <div class="detail-item"><span>TOTAL NILAI</span><strong>Rp {{ number_format($asset->quantity * (float) $asset->price, 0, ',', '.') }}</strong></div>
            <div class="detail-item detail-notes"><span>CATATAN</span><p>{{ $asset->notes ?: 'Tidak ada catatan untuk aset ini.' }}</p></div>
        </div>
        <div class="detail-actions">
            <a class="button button-secondary" href="{{ route('assets.index') }}">Kembali ke daftar</a>
            <form action="{{ route('assets.destroy', $asset) }}" method="POST" onsubmit="return confirm('Hapus aset ini? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button class="button button-delete" type="submit">Hapus aset</button>
            </form>
        </div>
    </section>
@endsection
