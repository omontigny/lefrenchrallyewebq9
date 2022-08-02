<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventsToApplicationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('applications', function (Blueprint $table) {
      //
      $table->unsignedBigInteger('event_id')->nullable();
      $table->foreign('event_id')->references('id')->on('groups')->onDelete('cascade');
      $table->integer('evented')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('applications', function (Blueprint $table) {
      //
      $table->dropColumn(['event_id']);
      $table->dropColumn(['evented']);
    });
  }
}
