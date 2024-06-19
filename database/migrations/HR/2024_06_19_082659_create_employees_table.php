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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('nationality')->nullable();
            $table->decimal('salary',64,2)->default(0);
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->enum('gender',['male','female'])->default('male');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('note')->nullable();
            $table->decimal('annual_leave',64,2)->default(0);
            $table->decimal('absence_amount',64,2)->default(0);
            $table->enum('salary_type',['monthly','weekly','daily'])->default('monthly');
            $table->decimal('overtime_amount',64,2)->default(0);
            $table->foreignIdFor(\App\Models\HR\IdentityType::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->restrictOnDelete();
            $table->morphs("ownerable");
            $table->foreignIdFor(\App\Models\Settings\Currency::class)->constrained()->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
