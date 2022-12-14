<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRallyeTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admin_rallye', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->bigInteger('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

      $table->bigInteger('rallye_id')->unsigned();
      $table->foreign('rallye_id')->references('id')->on('rallyes')->onDelete('cascade');

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
    Schema::dropIfExists('admin_rallye');
  }
}
