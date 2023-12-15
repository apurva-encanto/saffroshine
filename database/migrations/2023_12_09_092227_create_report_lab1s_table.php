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
        Schema::create('report_lab1', function (Blueprint $table) {
            $table->id();
            $table->integer('lab_id');
            $table->integer('user_id')->nullable();
            $table->string('congealing_point');
            $table->string('needle_penetration');
            $table->string('r_b_soft_point');
            $table->string('soft_pt_remark');
            $table->integer('status')->default(1);
            $table->integer('is_delete')->default(0);
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_lab1s');
    }
};
