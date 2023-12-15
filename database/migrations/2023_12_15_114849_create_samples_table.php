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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->string('raw_material');
            $table->integer('quantity');
            $table->string('wax_batch_no');
            $table->string('wax_grade_no');
            $table->integer('lab_id');
            $table->integer('assign_for');
            $table->integer('approved');
            $table->integer('is_edit');
            $table->integer('status');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
