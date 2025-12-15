<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('cnpj_cpf')->unique();
            $table->string('trade_name');
            $table->string('logo_url')->nullable();
            $table->json('operating_hours')->nullable();
            $table->enum('subscription_status', ['Active', 'Overdue', 'Cancelled'])->default('Active');
            $table->date('trial_ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
