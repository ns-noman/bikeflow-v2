<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bike_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->bigInteger('bike_service_category_id');
            $table->string('name');
            $table->decimal('trade_price', 10,2)->default(0.00);
            $table->decimal('price', 10,2)->default(0.00);
            $table->unsignedTinyInteger('status')->default(1)->comment('0=Inactive, 1=Active');
            $table->timestamps();
            $table->index('company_id');
        });
    }
    public function down()
    {
        Schema::dropIfExists('bike_services');
    }
};
