<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('branding_logo', 255);
            $table->string('avatar', 255);
            $table->string('welcome_message', 255);
            $table->string('language', 100)->default('English');
            $table->string('date_format')->default('utc');
            $table->tinyInteger('time_format')->default(24);
            $table->string('country', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('branding_logo');
            $table->dropColumn('avatar');
            $table->dropColumn('welcome_message');
            $table->dropColumn('language');
            $table->dropColumn('date_format');
            $table->dropColumn('time_format');
            $table->dropColumn('country');
        });
    }
}
