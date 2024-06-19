<?php

use App\Models\Inventory\Item;
use App\Models\Settings\Currency;
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
        Schema::create('purchase_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Currency::class)->constrained()->restrictOnDelete();
            $table->float("single_quantity", 2)->default(1);
            $table->float("multiple_quantity", 2)->default(1);
            $table->float("single_gift", 2)->default(1);
            $table->float("multiple_gift", 2)->default(1);
            $table->decimal("single_price", 64, 2)->default(0);
            $table->decimal("multiple_price", 64, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoice_details');
    }
};
