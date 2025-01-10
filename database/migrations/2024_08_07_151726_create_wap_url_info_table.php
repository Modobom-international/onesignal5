<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWapUrlInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wap_url_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_user');
            $table->string('country');
            $table->string('platform');
            $table->string('url');
            $table->string('otp');
            $table->string('date');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wap_url_info');
    }
}
