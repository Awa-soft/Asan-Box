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
        Schema::create('item_transaction_invoices', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->morphs('fromable');
            $table->morphs('toable');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_transaction_invoices');
    }
};
