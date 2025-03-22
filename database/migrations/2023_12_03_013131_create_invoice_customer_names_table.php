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
        Schema::create('invoice_customer_names', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('po_number')->nullable();
            $table->string('date')->nullable();
            $table->string('due_date')->nullable();
            $table->string('enable_tax')->nullable();
            $table->string('recurring_incoice')->nullable();
            $table->string('by_month')->nullable();
            $table->string('month')->nullable();
            $table->longText('invoice_from')->nullable();
            $table->longText('invoice_to')->nullable();
            $table->longText('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_customer_names');
    }
};
