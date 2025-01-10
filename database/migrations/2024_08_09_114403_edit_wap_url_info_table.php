<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditWapUrlInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('wap_url_info', function (Blueprint $table) {
            $table->string('network')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('platform')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->string('otp')->nullable()->change();
            $table->string('date')->nullable()->change();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wap_url_info', function (Blueprint $table) {
            $table->dropColumn('network');
        });
    }
}
