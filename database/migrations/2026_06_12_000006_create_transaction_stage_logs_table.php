<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_stage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_transaction_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('stage_code');
            $table->enum('status', ['pending', 'in_progress', 'done', 'skipped', 'failed'])->default('pending');
            // tahap 3 (KPR): submitted | survey | slik_check | sp2k_issued | rejected
            $table->string('kpr_sub_status')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('pic_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('stage_code')->references('stage_code')->on('pipeline_stages');
            $table->index(['sale_transaction_id', 'stage_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_stage_logs');
    }
};
