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
            $table->string('name')->nullable();
            $table->string('role_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile_no')->unique()->nullable();
            $table->string('mobile_otp')->nullable();
            $table->integer('mobile_verified_at')->default(0);
            $table->integer('email_verified_at')->default(0);
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('password')->nullable();
            $table->string('visible_password')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
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
