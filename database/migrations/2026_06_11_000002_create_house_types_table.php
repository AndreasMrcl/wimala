<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('house_types', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedInteger('luas_tanah')->default(0);
            $table->unsignedInteger('luas_bangunan')->default(0);
            $table->unsignedTinyInteger('kamar_tidur')->default(0);
            $table->unsignedTinyInteger('kamar_mandi')->default(0);
            $table->decimal('harga_dasar', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('house_types');
    }
};
