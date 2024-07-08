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
        Schema::create('item_transaction_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Inventory\ItemTransactionDetail::class)->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->enum('status',['pending', 'rejected', 'accepted']);
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->date('status_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_transaction_codes');
    }
};
