<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_ship_id')->unsigned();
            $table->integer('shipper_id')->unsigned();
            $table->dateTime('pickup_time')->nullable();
            $table->dateTime('dropoff_time')->nullable();
            $table->float('package_owner_rating')->nullable();
            $table->float('receiver_rating')->nullable();
            $table->float('shipper_rating')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('request_ship_id')->references('id')->on('request_ships');
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
        Schema::dropIfExists('trips');
    }
}
