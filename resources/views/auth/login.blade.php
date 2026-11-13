@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="auth-heading">
        <div class="eyebrow"><span class="eyebrow-line"></span>SELAMAT DATANG KEMBALI</div>
        <h1>Masuk ke akun Anda</h1>
        <p>Gunakan email dan kata sandi yang terdaftar.</p>
    </div>

    <form class="auth-form" action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="auth-field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
            @error('email')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <div class="auth-field">
            <label for="password">Kata sandi</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password')<span class="field-error">{{ $message }}</span>@enderror
        </div>
        <label class="remember-option">
            <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
            <span>Ingat saya</span>
        </label>
        <button class="button button-primary auth-submit" type="submit">Masuk</button>
    </form>

    <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
@endsection
