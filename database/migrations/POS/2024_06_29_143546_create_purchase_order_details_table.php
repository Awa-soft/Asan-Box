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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Inventory\Item::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\POS\PurchaseOrder::class)->constrained()->restrictOnDelete();
            $table->decimal('quantity',64,2);
            $table->foreignIdFor(\App\Models\Inventory\Unit::class)->constrained()->restrictOnDelete();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
