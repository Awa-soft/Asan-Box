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
        Schema::create('employee_leavs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\HR\Employee::class)->constrained()->restrictOnDelete();
            $table->dateTime('from');
            $table->dateTime('to');
            $table->string('note')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->foreignIdFor(\App\Models\Logistic\Branch::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leavs');
    }
};
