<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushSystemGlobalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('push_system_globals')) {
            Schema::create('push_system_globals', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('token')->nullable();
                $table->string('app')->nullable();
                $table->string('country')->nullable();
                $table->boolean('status')->nullable();
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
        Schema::dropIfExists('push_system_globals');
    }
}
