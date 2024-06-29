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
        Schema::create('branch_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Logistic\Branch::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\CRM\Partner::class)->constrained()->cascadeOnDelete();
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
