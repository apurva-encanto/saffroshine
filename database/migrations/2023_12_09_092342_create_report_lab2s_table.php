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
        Schema::create('report_lab2', function (Blueprint $table) {
            $table->id();
            $table->integer('lab_id');
            $table->integer('user_id')->nullable();
            $table->string('bf_viscosity');
            $table->string('bf_viscosity_90');
            $table->string('bf_viscosity_100');
            $table->string('bf_viscosity_120');
            $table->string('mor_img');
            $table->string('dilatometer_img');
            $table->string('dilatometer_60');
            $table->string('dilatometer_90');
            $table->string('dilatometer_100');
            $table->string('dilatometer_120');
            $table->string('dsc_img');
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
        Schema::dropIfExists('report_lab2s');
    }
};
