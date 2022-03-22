<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveRallyeToCoordinatorRallyeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coordinator_rallye', function (Blueprint $table) {
            //
            $table->string('active_rallye')->nullable()->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coordinator_rallye', function (Blueprint $table) {
            //
            $table->dropColumn(['active_rallye']);
        });
    }
}
