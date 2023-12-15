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
        Schema::create('report_waxes', function (Blueprint $table) {
            $table->id();
            $table->integer('lab_id');
            $table->integer('user_id')->nullable();
            $table->string('wax_machine_name');
            $table->string('wax_tank_temp');
            $table->string('wax_block_temp');
            $table->string('wax_injection');
            $table->string('injection_temp');
            $table->string('wax_flow');
            $table->string('wax_cooling_temp');
            $table->string('wax_solidification');
            $table->string('surface_finish');
            $table->string('flow_link');
            $table->string('surface_sink');
            $table->string('step_bar_die_sink');
            $table->integer('is_delete')->default(0);
            $table->integer('is_status')->default(1);
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_waxes');
    }
};
