<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_listings', function (Blueprint $table) {
            $table->id();

            // Multi-Tenant & Bike Reference
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('bike_attribute_id');
            $table->unsignedBigInteger('used_bike_id')->nullable();

            // Pricing
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->boolean('negotiable')->default(true);

            // Stock (Mainly for New Bikes)
            $table->integer('stock_quantity')->default(1);

            // Condition & Used Bike Info
            $table->tinyInteger('condition')->default(0)->comment('0: Used, 1: New');
            $table->integer('mileage')->nullable();
            $table->integer('ownership_count')->default(1);

            // Legal Info (Important for Used Bikes)
            $table->date('fitness_valid_until')->nullable();
            $table->date('tax_valid_until')->nullable();
            $table->date('insurance_valid_until')->nullable();

            // Media & Display
            $table->boolean('use_default_image')->default(true);
            $table->boolean('is_online_posted')->default(false);

            // Moderation & Status
            $table->tinyInteger('status')->default(0)->comment('0: Pending, 1: Approved, 2: Rejected');
            $table->unsignedBigInteger('approved_by_id')->nullable();


            $table->timestamps();

            // Indexes
            $table->index('company_id');
            $table->index('bike_attribute_id');
            $table->index('status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bike_listings');
    }
};
