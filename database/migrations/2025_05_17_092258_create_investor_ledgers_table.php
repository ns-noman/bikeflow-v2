<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('investor_ledgers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('investor_id');
            $table->bigInteger('account_id');
            $table->string('particular')->nullable();
            $table->decimal('debit_amount', 20, 2)->nullable()->comment('Withdrawal');
            $table->decimal('credit_amount', 20, 2)->nullable()->comment('Deposit');
            $table->decimal('current_balance', 20, 2);
            $table->string('reference_number')->unique()->nullable();
            $table->date('transaction_date');
            $table->bigInteger('created_by_id')->nullable();
            $table->bigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('investor_ledgers');
    }
};
