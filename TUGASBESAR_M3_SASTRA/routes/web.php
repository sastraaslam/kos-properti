<?php

use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

// ===== Modul A: Master Kamar (Je) =====
// Tambahkan route Master Kamar di bagian ini.

// ===== Modul B: Data Penghuni (Jdm) =====
// Tambahkan route Data Penghuni di bagian ini.

// ===== Modul C: Housekeeper (Iq) =====
// Tambahkan route Housekeeper di bagian ini.

// ===== Modul D: Inventaris Aset (Sas) =====
Route::get('/', [AssetController::class, 'index'])->name('assets.index');
Route::resource('assets', AssetController::class)->except('index');
