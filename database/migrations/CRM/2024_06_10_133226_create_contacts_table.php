<?php

use App\Models\Logistic\Branch;
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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string("name_en");
            $table->string("name_ar");
            $table->string("name_ckb");
            $table->string("phone")->nullable()->unique();
            $table->string("email")->nullable()->unique();
            $table->string("address")->nullable();
            $table->string("type")->default("Customer");
            $table->integer("payment_duration")->nullable();
            $table->decimal("max_debt", 64,2)->nullable();
            $table->boolean("status")->default(1);
            $table->string("image")->nullable();
            $table->morphs("ownerable");
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};
