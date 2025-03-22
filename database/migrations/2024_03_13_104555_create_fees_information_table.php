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
        Schema::create('fees_information', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->nullable();
            $table->string('student_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('fees_type')->nullable();
            $table->string('fees_amount')->nullable();
            $table->string('paid_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_information');
    }
};
