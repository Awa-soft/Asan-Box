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
        Schema::create('cash_management', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\CRM\PartnerAccount::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Settings\Currency::class)->constrained()->restrictOnDelete();
            $table->decimal('amount',64,4)->default(0);
            $table->enum('type',['deposit', 'withdraw', 'profit'])->default('deposit');
            $table->text('note')->nullable();
            $table->decimal('rate',64,4)->default(1);
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_management');
    }
};
