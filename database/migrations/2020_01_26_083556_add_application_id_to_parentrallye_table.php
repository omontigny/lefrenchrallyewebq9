<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApplicationIdToParentRallyeTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('parent_rallye', function (Blueprint $table) {
      //
      $table->bigInteger('application_id')->unsigned()->nullable();
      $table->foreign('application_id')->references('id')->on('applications');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('parent_rallye', function (Blueprint $table) {
      //
      $table->dropColumn('application_id');
    });
  }
}
