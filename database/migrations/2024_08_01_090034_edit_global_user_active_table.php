<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditGlobalUserActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('push_system_global_user_active', function (Blueprint $table) {
            $table->dateTime('activated_at')->nullable();
            $table->dropColumn('datetime');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('push_system_global_user_active', function (Blueprint $table) {
            $table->dropColumn('activated_at');
        });
    }
}
