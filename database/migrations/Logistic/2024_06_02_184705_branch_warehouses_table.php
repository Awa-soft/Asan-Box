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
        Schema::create('branch_warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Logistic\Warehouse::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\Logistic\Branch::class)->constrained()->restrictOnDelete();
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
