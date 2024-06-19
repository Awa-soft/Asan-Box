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
        Schema::create('bourses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("phone")->nullable()->unique();
            $table->string("email")->nullable()->unique();
            $table->string("address")->nullable();
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
        Schema::dropIfExists('bourses');
    }
};
