<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->bigInteger('brand_id')->after('bike_attribute_id');
        });
    }

    public function down()
    {
        Schema::table('bikes', function (Blueprint $table) {
            //
        });
    }
};
