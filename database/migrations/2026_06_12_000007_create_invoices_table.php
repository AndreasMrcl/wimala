<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_transaction_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('no_invoice')->unique();
            // booking_fee | dp | cicilan | pelunasan | pencairan_bank
            $table->string('jenis_termin');
            $table->decimal('jumlah', 15, 2);
            $table->date('jatuh_tempo');
            $table->enum('status', ['unpaid', 'paid', 'late'])->default('unpaid');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
