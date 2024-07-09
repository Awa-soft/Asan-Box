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
        Schema::create('item_losses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Inventory\Item::class)->constrained()->restrictOnDelete();
            $table->string('code');
            $table->decimal('cost',64,2)->default(0);
            $table->foreignIdFor(\App\Models\Settings\Currency::class)->constrained()->restrictOnDelete();
            $table->decimal('rate',64,4);
            $table->string('note')->nullable();
            $table->date('date')->nullable();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
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
        Schema::dropIfExists('item_losses');
    }
};
