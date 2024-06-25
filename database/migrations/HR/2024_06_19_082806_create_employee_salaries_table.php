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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\HR\Employee::class)->constrained()->restrictOnDelete();
            $table->decimal('amount', 64, 2);
            $table->decimal('payment_amount', 64, 2);
            $table->date('salary_date');
            $table->date('payment_date');
            $table->string('note')->nullable();
            $table->foreignIdFor(\App\Models\Settings\Currency::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->decimal('currency_rate', 64, 2);
            $table->decimal('work_average', 64, 2)->default(8);
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
        Schema::dropIfExists('employee_salaries');
    }
};
