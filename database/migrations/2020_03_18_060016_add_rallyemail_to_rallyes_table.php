<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRallyemailToRallyesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rallyes', function (Blueprint $table) {
            //
            $table->string('rallyemail')->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rallyes', function (Blueprint $table) {
            //
            $table->dropColumn(['rallyemail']);
        });
    }
}
