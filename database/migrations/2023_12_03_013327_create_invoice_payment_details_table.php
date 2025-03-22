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
        Schema::create('invoice_payment_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('add_terms_and_Conditions')->nullable();
            $table->string('add_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payment_details');
    }
};
