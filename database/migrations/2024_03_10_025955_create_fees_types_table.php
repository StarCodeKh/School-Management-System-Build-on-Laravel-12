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
        Schema::create('fees_types', function (Blueprint $table) {
            $table->id();
            $table->string('fees_type')->nullable();
            $table->timestamps();
        });
        DB::table('fees_types')->insert([
            ['fees_type' => 'Class Test'],
            ['fees_type' => 'Exam Fees'],
            ['fees_type' => 'Hostel Fees'],
            ['fees_type' => 'Transport Fees'],
            ['fees_type' => 'Mess Fees'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_types');
    }
};
