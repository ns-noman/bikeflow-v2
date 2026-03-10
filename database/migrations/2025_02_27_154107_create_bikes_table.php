<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->bigInteger('brand_id');
            $table->bigInteger('model_id');
            $table->bigInteger('color_id');
            $table->bigInteger('bike_attribute_id');
            $table->tinyInteger('bike_type')->default(0)->comment('oldbike=0, newbike=1')->after('manufacture_year');
            $table->year('manufacture_year');
            $table->string('registration_no')->nullable(); 
            $table->string('chassis_no')->unique(); 
            $table->string('engine_no')->unique();
            $table->timestamps();
            $table->index('company_id');
        });
    }
    public function down()
    {
        Schema::dropIfExists('bikes');
    }
};
