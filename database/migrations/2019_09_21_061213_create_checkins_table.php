<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('checkins', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->bigInteger('rallye_id')->unsigned();
      $table->foreign('rallye_id')->references('id')->on('rallyes')->onDelete('cascade');

      $table->bigInteger('group_id')->unsigned();
      $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

      $table->bigInteger('child_id')->unsigned();
      $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

      $table->boolean('checkStatus')->default(false);

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
    Schema::dropIfExists('checkins');
  }
}
