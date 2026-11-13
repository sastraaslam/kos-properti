@extends('layouts.guest')

@section('title', 'Registrasi')

@section('content')
    <div class="auth-heading">
        <div class="eyebrow"><span class="eyebrow-line"></span>BUAT AKUN RUANGKOS</div>
        <h1>Daftar akun baru</h1>
        <p>Lengkapi data berikut untuk mulai menggunakan RuangKos.</p>
    </div>

    <form class="auth-form" action="{{ route('register.store') }}" method="POST">
        @csrf
        <div class="auth-field">
            <label for="name">Nama lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="255" required autofocus>
            @error('name')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="auth-field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
            @error('email')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="auth-field">
            <label for="password">Kata sandi <span class="auth-hint">(minimal 8 karakter)</span></label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
            @error('password')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="auth-field">
            <label for="password_confirmation">Konfirmasi kata sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
        </div>
        <button class="button button-primary auth-submit" type="submit">Buat akun</button>
    </form>

    <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
@endsection
