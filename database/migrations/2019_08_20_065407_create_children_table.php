<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // Info child
            $table->string('childfirstname');
            $table->string('childlastname');          
            $table->datetime('childbirthdate');
            $table->string('childgender');
            $table->string('childemail');
            $table->longtext('childphotopath')->nullable();
            // Info Parent
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('id')->on('parents');
            // Info rallye
            $table->unsignedBigInteger('rallye_id');
            $table->foreign('rallye_id')->references('id')->on('rallyes');
            // Info application
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications');

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
        Schema::dropIfExists('children');
    }
}
