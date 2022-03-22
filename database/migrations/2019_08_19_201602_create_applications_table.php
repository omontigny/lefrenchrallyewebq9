<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.  
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
        $table->bigIncrements('id');
        
        $table->unsignedBigInteger('rallye_id');
        $table->foreign('rallye_id')->references('id')->on('rallyes');
        
        // Info child
        $table->string('childfirstname');
        $table->string('childlastname');
        $table->date('childbirthdate');
        $table->string('childgender');
        $table->string('childemail')->nullable()->default('');
        $table->longtext('childphotopath')->nullable();
        
        // Info family
        $table->string('simblingList')->nullable()->default('');
        
        // Info insurance
        $table->boolean('hasinsurancecover')->nullable()->default(false);

        // Info school
        $table->unsignedBigInteger('school_id');
        $table->foreign('school_id')->references('id')->on('schools');
        $table->unsignedBigInteger('schoolyear_id');
        $table->foreign('schoolyear_id')->references('id')->on('schoolyears');
        $table->string('schoolstate')->nullable()->default('');
 
        // Info Preferences
        $table->string('preferredmember1')->nullable()->default('');
        $table->string('preferredmember2')->nullable()->default('');
        $table->date('preferreddate1')->nullable();
        $table->date('preferreddate2')->nullable();

        // parent info
        $table->string('parentfirstname');
        $table->string('parentlastname');
        $table->string('parentaddress');
        $table->string('parenthomephone')->nullable();
        $table->string('parentmobile')->nullable();
        $table->string('parentemail')->nullable();
        
        // Info Code conduct
        $table->string('signingcodeconduct');
        $table->boolean('dpp1')->nullable();
        $table->boolean('dpp2')->nullable();
        $table->boolean('otc1')->nullable();
        $table->boolean('otc2')->nullable();
        /*
        // Info application
        $table->datetime('applicationdate')->nullable();
        */

        //$table->unsignedBigInteger('approvedby')->nullable();
        //$table->foreign('approvedby')->references('id')->on('users');
        
        $table->integer('status')->default(0);
        
        $table->unsignedBigInteger('parent_id')->nullable();
        $table->foreign('parent_id')->references('id')->on('parents');

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
        Schema::dropIfExists('applications');
    }
}
