<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentRallyeTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('parent_rallye', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->bigInteger('parent_id')->unsigned();
      $table->foreign('parent_id')->references('id')->on('parents');

      $table->bigInteger('rallye_id')->unsigned();
      $table->foreign('rallye_id')->references('id')->on('rallyes');

      $table->string('active_rallye')->nullable()->default('');

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
    Schema::dropIfExists('parent_rallye');
  }
}
