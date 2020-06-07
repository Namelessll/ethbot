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
            $table->double('balance')->default(0);
            $table->bigInteger('referals')->nullable(0);
            $table->bigInteger('invite')->nullable();
            $table->boolean('ban')->default(false);
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
