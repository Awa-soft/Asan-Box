<?php

use App\Models\CRM\Contact;
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
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->string("type")->default('purchase');
            $table->string("invoice_number");
            $table->date("date");
            $table->integer('months')->default(0);
            $table->decimal("paid_amount",64, 2)->default(0);
            $table->foreignIdFor(Contact::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Currency::class)->constrained()->restrictOnDelete();
            $table->decimal("rate", 64, 2);
            $table->decimal("balance", 64, 2)->default(0);
            $table->decimal("discount", 64, 2)->default(0);
            $table->foreignIdFor(User::class)->constrained()->restrictOnDelete();
            $table->text("note")->nullable();
            $table->foreignIdFor(Branch::class)->constrained()->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_invoices');
    }
};
