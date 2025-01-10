<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetPushSystemSettingGlobalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('get_push_system_setting_global_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip');
            $table->string('domain');
            $table->text('user_agent');
            $table->longText('data');
            $table->string('link_web');
            $table->string('share_web');
            $table->dateTime('created_date');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_push_system_setting_global_requests');
    }
}
