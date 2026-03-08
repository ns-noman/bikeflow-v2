<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bike_services', function (Blueprint $table) {
            $table->double('trade_price', 20,2)->default(0.00)->after('name');
        });
    }

    public function down()
    {
        Schema::table('bike_services', function (Blueprint $table) {
            //
        });
    }
};
