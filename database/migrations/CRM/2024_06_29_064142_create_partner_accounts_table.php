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
        Schema::create('partner_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\CRM\Partnership::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\CRM\Partner::class)->constrained()->restrictOnDelete();
            $table->float('percent');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_accounts');
    }
};
