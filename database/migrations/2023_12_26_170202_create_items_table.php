<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('cat_type_id');
            $table->integer('cat_id');
            $table->integer('sub_cat_id')->nullable();
            $table->integer('unit_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->double('purchase_price',20,2)->default(0.00);
			$table->double('sale_price',20,2)->default(0.00);
			$table->float('vat',5,2)->default(0);
            $table->double('sold_qty',20,2)->default(0);
            $table->double('current_stock',20,2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
