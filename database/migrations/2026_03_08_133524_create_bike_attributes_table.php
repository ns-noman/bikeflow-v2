<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bike_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id');
            $table->bigInteger('model_id');
            $table->bigInteger('color_id');
            $table->year('manufacture_year');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('bike_attributes');
    }
};
