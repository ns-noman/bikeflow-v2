<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->tinyInteger('bike_type')
                  ->default(0)
                  ->comment('oldbike=0, newbike=1')
                  ->after('manufacture_year');
        });
    }

    public function down()
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->dropColumn('bike_type');
        });
    }
};