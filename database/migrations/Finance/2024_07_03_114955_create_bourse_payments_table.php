<?php

use App\Models\CRM\Bourse;
use App\Models\Logistic\Branch;
use App\Models\Settings\Currency;
use App\Models\User;
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
        Schema::create('bourse_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Bourse::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Currency::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Branch::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->decimal('amount', 64, 2);
            $table->decimal('rate', 64, 2);
            $table->decimal('balance', 64, 2);
            $table->string('type');
            $table->date('date');
            $table->string('attachment')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bourse_payments');
    }
};
