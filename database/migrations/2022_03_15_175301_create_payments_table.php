<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('payments', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('payment_id');

      $table->bigInteger('application_id')->unsigned();
      $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');

      $table->bigInteger('rallye_id')->unsigned();
      $table->foreign('rallye_id')->references('id')->on('rallyes')->onDelete('cascade');

      $table->string('payer_email');
      $table->float('amount');
      $table->string('currency');
      $table->string('description');
      $table->string('payment_status');
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
    Schema::dropIfExists('payments');
  }
}
