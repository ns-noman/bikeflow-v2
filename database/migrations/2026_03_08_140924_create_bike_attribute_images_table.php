<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bike_attribute_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attribute_id')->unsigned();
            $table->string('image');
            $table->string('caption')->nullable();
            $table->boolean('is_thumbnail')->default(false)->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('bike_attribute_images');
    }
};
