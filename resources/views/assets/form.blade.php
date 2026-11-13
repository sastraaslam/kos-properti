@extends('layouts.app')

@section('title', $pageTitle)
@section('section', $pageTitle)

@section('content')
    <div class="page-heading">
        <div>
            <a class="back-link" href="{{ route('assets.index') }}">← Kembali ke daftar aset</a>
            <div class="eyebrow"><span class="eyebrow-line"></span>INVENTARIS PROPERTI</div>
            <h1>{{ $pageTitle }}</h1>
            <p class="page-subtitle">Lengkapi informasi aset agar inventaris kos selalu akurat.</p>
        </div>
    </div>

    <form class="panel form-panel" action="{{ $asset->exists ? route('assets.update', $asset) : route('assets.store') }}" method="POST">
        @csrf
        @if ($asset->exists)
            @method('PUT')
        @endif

        <div class="form-section-heading">
            <span class="form-section-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 4.3 7.5-4.3M12 12v8.5" stroke="currentColor" stroke-width="1.7"/></svg></span>
            <div><h2>Informasi aset</h2><p>Informasi dasar dan penempatan aset.</p></div>
        </div>

        <div class="form-grid">
            <div class="field-group">
                <label for="name">Nama aset <span class="required">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name', $asset->name) }}" placeholder="Contoh: AC Split 1 PK" maxlength="150" required>
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
                <label for="category">Kategori <span class="required">*</span></label>
                <select id="category" name="category" required>
                    <option value="" disabled @selected(old('category', $asset->category) === null)>Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(old('category', $asset->category) === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
                <label for="location">Lokasi / kamar <span class="required">*</span></label>
                <input id="location" name="location" type="text" value="{{ old('location', $asset->location) }}" placeholder="Contoh: Kamar 2 atau Ruang bersama" maxlength="120" required>
                @error('location')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
                <label for="quantity">Jumlah unit <span class="required">*</span></label>
                <input id="quantity" name="quantity" type="number" value="{{ old('quantity', $asset->quantity ?: 1) }}" min="1" max="100000" required>
                @error('quantity')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
                <label for="asset_condition">Kondisi <span class="required">*</span></label>
                <select id="asset_condition" name="asset_condition" required>
                    <option value="" disabled @selected(old('asset_condition', $asset->asset_condition) === null)>Pilih kondisi</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition }}" @selected(old('asset_condition', $asset->asset_condition ?: 'Baik') === $condition)>{{ $condition }}</option>
                    @endforeach
                </select>
                @error('asset_condition')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
                <label for="status">Status penggunaan <span class="required">*</span></label>
                <select id="status" name="status" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', $asset->status ?: 'Digunakan') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                @error('status')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
                <label for="purchase_date">Tanggal pembelian</label>
                <input id="purchase_date" name="purchase_date" type="date" value="{{ old('purchase_date', $asset->purchase_date?->format('Y-m-d')) }}">
                @error('purchase_date')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group">
                <label for="price">Harga per unit <span class="required">*</span></label>
                <div class="input-prefix"><span>Rp</span><input id="price" name="price" type="number" value="{{ old('price', $asset->price ?? '0') }}" placeholder="0" min="0" step="0.01" required></div>
                @error('price')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field-group field-full">
                <label for="notes">Catatan <span class="optional">(opsional)</span></label>
                <textarea id="notes" name="notes" rows="4" maxlength="2000" placeholder="Tambahkan merek, nomor seri, atau catatan lain...">{{ old('notes', $asset->notes) }}</textarea>
                @error('notes')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-footer">
            <a class="button button-secondary" href="{{ $asset->exists ? route('assets.show', $asset) : route('assets.index') }}">Batal</a>
            <button class="button button-primary" type="submit">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m5 12.5 4.5 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ $submitLabel }}
            </button>
        </div>
    </form>
@endsection
