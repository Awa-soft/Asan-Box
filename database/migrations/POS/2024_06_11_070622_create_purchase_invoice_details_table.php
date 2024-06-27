<?php

use App\Models\Inventory\Item;
use App\Models\POS\PurchaseInvoice;
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
            $table->foreignIdFor(PurchaseInvoice::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Item::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Currency::class)->constrained()->restrictOnDelete();
            $table->float("quantity", 2)->default(1);
            $table->float("gift", 2)->default(0);
            $table->decimal("price", 64, 2)->default(0);
            $table->decimal("currency_rate", 64, 2)->default(0);
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
