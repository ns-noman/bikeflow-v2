<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();

            $table->string('logo');
            $table->string('favicon');

            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email');
            $table->text('address');

            //social
            $table->text('web_link')->nullable();
            $table->text('facebook_link')->nullable();
            $table->text('x_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('youtube_link')->nullable();


            //embed links
            $table->longText('map_embed');
            
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
