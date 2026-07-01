<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('buyer_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('marketing_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('payment_method', ['cash_keras', 'cash_bertahap', 'kpr']);
            $table->foreignId('bank_id')->nullable()->constrained()->nullOnDelete();
            $table->string('current_stage_code');
            $table->enum('status', ['active', 'cancelled', 'completed'])->default('active');
            $table->text('cancelled_reason')->nullable();
            $table->timestamps();

            $table->foreign('current_stage_code')->references('stage_code')->on('pipeline_stages');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_transactions');
    }
};
