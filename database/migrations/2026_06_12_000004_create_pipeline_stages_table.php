<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pipeline_stages', function (Blueprint $table) {
            $table->string('stage_code')->primary();
            $table->unsignedTinyInteger('sequence');
            $table->string('name');
            // always | payment_method=kpr | delivery_type=indent
            $table->string('applicable_rule')->default('always');
            // null | booked | sold | handed_over | completed
            $table->string('unit_status_trigger')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pipeline_stages');
    }
};
