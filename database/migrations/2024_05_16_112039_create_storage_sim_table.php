<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageSimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_sim', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone')->nullable();
            $table->string('network')->nullable();
            $table->date('estimate_date')->nullable();
            $table->date('last_online_date')->nullable();
            $table->string('note')->nullable();
            $table->string('time_to_use')->default(0);
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
        Schema::dropIfExists('storage_sim');
    }
}
