<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushSystemGlobalUserActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('push_system_global_user_active')) {
            Schema::create('push_system_global_user_active', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('token');
                $table->string('country');
                $table->dateTime('datetime');
                $table->date('activated_date');
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
        Schema::dropIfExists('push_system_global_user_active');
    }
}
