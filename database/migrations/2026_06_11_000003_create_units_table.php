<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cluster_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('house_type_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('kode')->unique();
            $table->string('blok')->nullable();
            $table->string('nomor')->nullable();
            $table->unsignedInteger('luas_tanah')->default(0);
            $table->unsignedInteger('luas_bangunan')->default(0);
            $table->decimal('harga', 15, 2)->default(0);
            $table->enum('delivery_type', ['ready_stock', 'indent'])->default('ready_stock');
            $table->enum('status', ['available', 'booked', 'sold', 'handed_over', 'completed'])->default('available');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
