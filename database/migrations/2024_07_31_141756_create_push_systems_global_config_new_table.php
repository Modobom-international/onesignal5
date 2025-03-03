<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushSystemsGlobalConfigNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('push_systems_global_config_new')) {
            Schema::create('push_systems_global_config_new', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('status');
                $table->string('type');
                $table->integer('share');
                $table->longText('link_web_1');
                $table->longText('link_web_2');
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
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
        Schema::dropIfExists('push_systems_global_config_new');
    }
}
