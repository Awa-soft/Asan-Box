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
            $table->foreignId('single_unit_id')->constrained("units")->restrictOnDelete();
            $table->foreignId('multiple_unit_id')->constrained("units")->restrictOnDelete();
            $table->decimal("single_price",64,2)->default(0);
            $table->decimal("multiple_price",64,2)->default(0);
            $table->integer("benifit_ratio")->default(0);
            $table->decimal("multi_quantity", 64, 2)->default(1);
            $table->date('expire_date')->nullable();
            $table->string("image")->nullable();
            $table->morphs("ownerable");
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
