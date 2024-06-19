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
        Schema::create('team_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\HR\Employee::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\HR\Team::class)->constrained()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_employees');
    }
};
