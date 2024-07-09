<?php

use App\Models\POS\SaleDetail;
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
        Schema::create('sale_detail_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SaleDetail::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Inventory\Item::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('sale_detail_codes');
    }
};
