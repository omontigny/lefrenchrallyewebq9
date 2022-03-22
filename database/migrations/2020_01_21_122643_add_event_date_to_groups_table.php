<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventDateToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            //
            $table->date('eventDate')->nullable();
            $table->integer('start_year')->nullable()->defaul(0);
            $table->integer('end_year')->nullable()->defaul(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            //
            $table->dropColumn(['eventDate']);
            $table->dropColumn(['start_year']);
            $table->dropColumn(['end_year']);
        });
    }
}
