<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSettingsBot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_settings_bot', function (Blueprint $table) {
            $table->id();
            $table->string('captcha_question')->nullable();
            $table->string('captcha_answer')->nullable();
            $table->longText('welcome_message')->nullable();
            $table->double('payment_registration')->default(0);
            $table->double('payment_out')->default(0);
            $table->double('payment_min')->default(0);
            $table->double('payment_max')->default(0);
            $table->double('payment_by_refer')->default(0);
            $table->integer('payment_by_refer_percent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_settings_bot');
    }
}
