<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrivingLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driving_licenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipper_id')->unsigned();
            $table->string('front_image');
            $table->string('back_image');
            $table->string('number_license');
            $table->string('type');
            $table->date('date');

            $table->foreign('shipper_id')->references('id')->on('shippers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driving_licenses');
    }
}
