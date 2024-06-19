<?php

use App\Models\Inventory\Item;
use App\Models\POS\PurchaseInvoiceDetail;
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
        Schema::create('purchase_detail_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PurchaseInvoiceDetail::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Item::class)->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('gift')->default("no");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_detail_codes');
    }
};
