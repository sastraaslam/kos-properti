<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public const CATEGORIES = [
        'Elektronik',
        'Furniture',
        'Perlengkapan Kamar',
        'Dapur',
        'Kebersihan',
        'Lainnya',
    ];

    public const CONDITIONS = [
        'Baik',
        'Perlu Perbaikan',
        'Rusak',
    ];

    public const STATUSES = [
        'Digunakan',
        'Disimpan',
        'Dalam Perbaikan',
    ];

    protected $fillable = [
        'name',
        'category',
        'location',
        'quantity',
        'asset_condition',
        'status',
        'purchase_date',
        'price',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'price' => 'decimal:2',
        ];
    }
}
