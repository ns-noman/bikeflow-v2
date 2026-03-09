<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id');
            $table->string('cat_name');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->index('company_id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
