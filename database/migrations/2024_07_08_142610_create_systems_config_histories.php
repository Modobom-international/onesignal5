<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemsConfigHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems_config_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('share_web');
            $table->string('link_web_1');
            $table->string('link_web_2');
            $table->dateTime('date_create');
            
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
        Schema::dropIfExists('systems_config_histories');
    }
}
