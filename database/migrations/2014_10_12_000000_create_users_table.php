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
            $table->string('role_name')->comment('admin,broker,user,sales and marketing')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile_no')->unique()->nullable();
            $table->string('verified_otp')->nullable();
            $table->integer('mobile_verified_at')->default(0);
            $table->integer('email_verified_at')->default(0);
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('password')->nullable();
            $table->string('visible_password')->nullable();
            $table->float('user_credit', 20, 2)->default(0);
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->softDeletes();
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
