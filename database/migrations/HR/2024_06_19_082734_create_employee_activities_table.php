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
        Schema::create('employee_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\HR\Employee::class)->constrained()->restrictOnDelete();
            $table->enum('type', ['punish', 'bonus', 'absence','advance','overtime']);
            $table->decimal('amount', 64, 2);
            $table->date('date');
            $table->text('note')->nullable();
            $table->foreignIdFor(\App\Models\Settings\Currency::class)->constrained()->restrictOnDelete();
            $table->morphs("ownerable");
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_activities');
    }
};
