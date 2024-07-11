<?php

use App\Models\Inventory\Brand;
use App\Models\Inventory\Category;
use App\Models\Logistic\Branch;
use App\Models\Logistic\Warehouse;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description")->nullable();
            $table->string("barcode")->nullable();
            $table->foreignIdFor(Category::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Brand::class)->constrained()->restrictOnDelete();
            $table->foreignId('unit_id')->constrained("units")->restrictOnDelete();
            $table->decimal("min_price",64,2)->default(0);
            $table->decimal("max_price",64,2)->default(0);
            $table->integer("discount")->default(0);
            $table->date('expire_date')->nullable();
            $table->string("image")->nullable();
            $table->decimal('installment_min');
            $table->decimal('installment_max');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
