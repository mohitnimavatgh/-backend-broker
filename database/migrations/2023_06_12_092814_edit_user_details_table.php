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
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('stripe_customer_id')->nullable()->after('certificate_photo');
            $table->string('stripe_subscriptions_id')->nullable()->after('stripe_customer_id');
            $table->string('stripe_subscriptions_item_id')->nullable()->after('stripe_subscriptions_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
