<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double('amount')->default(0);
            $table->integer('reference_id')->default(0);
            $table->double('credit')->default(0);
            $table->double('debit')->default(0);
            $table->string('bank_code', 30);
            $table->string('description')->nullable();
            $table->string('type'); //topup, withdraw, transfer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
