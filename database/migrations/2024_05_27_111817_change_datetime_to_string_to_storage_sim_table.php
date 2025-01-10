<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDatetimeToStringToStorageSimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storage_sim', function (Blueprint $table) {
            $table->text('estimate_date')->change();
            $table->text('last_online_date')->change();
            $table->text('end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storage_sim', function (Blueprint $table) {
            $table->date('estimate_date')->change();
            $table->date('last_online_date')->change();
            $table->date('end_date')->change();
        });
    }
}
