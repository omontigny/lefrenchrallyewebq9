<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('guests', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('guestfirstname');
      $table->string('guestlastname');
      $table->string('guestmobile');
      $table->string('guestemail');
      $table->bigInteger('nb_invitations');
      $table->bigInteger('invitedby_id')->unsigned();
      $table->foreign('invitedby_id')->references('id')->on('children')->onDelete('cascade');
      $table->bigInteger('rallye_id')->unsigned();
      $table->foreign('rallye_id')->references('id')->on('rallyes')->onDelete('cascade');
      $table->bigInteger('group_id')->unsigned();
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('guests');
  }
}
