<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneSenderAndSenderNameToServiceOtpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_otp', function (Blueprint $table) {
            $table->bigInteger('phone_sender')->nullable();
            $table->string('sender_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_otp', function (Blueprint $table) {
            $table->dropColumn('phone_sender');
            $table->dropColumn('sender_name');
        });
    }
}
