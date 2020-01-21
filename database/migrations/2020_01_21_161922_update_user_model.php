<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address1');
            $table->string('address2')->default('');
            $table->string('gender');
            $table->string('city');
            $table->string('country');
            $table->string('zipCode');
            $table->string('userType');
            $table->string('gameTitle');
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
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('gender');
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('zipCode');
            $table->dropColumn('userType');
            $table->dropColumn('gameTitle');
        });
    }
}
