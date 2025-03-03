<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuFilterLogBehavior extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('menu_filter_log_behavior')) {
            Schema::create('menu_filter_log_behavior', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('cookie_id');
                $table->text('menu');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_filter_log_behavior');
    }
}
