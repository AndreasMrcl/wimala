<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_entries', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('tipe', ['in', 'out']);
            $table->string('kategori');
            $table->decimal('jumlah', 15, 2);
            $table->string('keterangan')->nullable();
            // Sumber otomatis (cash basis): ref_type='payment', ref_id=payment id
            $table->string('ref_type')->nullable();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->timestamps();

            $table->index(['tipe', 'tanggal']);
            $table->index(['ref_type', 'ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_entries');
    }
};
