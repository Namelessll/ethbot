<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBotUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_bot_users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('username')->nullable();
            $table->double('balanceToken')->default(0);
            $table->double('balanceEth')->default(0);
            $table->longText('valetCode')->nullable();
            $table->bigInteger('referals')->default(0);
            $table->bigInteger('invite')->default(0);
            $table->boolean('status')->default(false);
            $table->boolean('ban')->default(false);
            $table->integer('valet')->default(0);
            $table->integer('convert')->default(0);
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
        Schema::dropIfExists('table_bot_users');
    }
}
