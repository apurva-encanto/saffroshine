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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_img')->nullable();
            $table->string('password');
            $table->string('role');
            $table->string('device_token')->nullable();
            $table->string('phone_no');
            $table->integer('parent_lab');
            $table->integer('lab_id');
            $table->integer('status')->default(1);
            $table->integer('is_delete')->default(0);
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
