<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('category', 60)->index();
            $table->string('location', 120);
            $table->unsignedInteger('quantity')->default(1);
            $table->string('asset_condition', 40)->index();
            $table->string('status', 40);
            $table->date('purchase_date')->nullable();
            $table->decimal('price', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
