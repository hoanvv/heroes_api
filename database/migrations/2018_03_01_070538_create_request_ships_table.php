<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Entities\RequestShip;

class CreateRequestShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_ships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('promo_code_id')->unsigned();
            $table->integer('package_type_id')->unsigned();
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('pickup_location');
            $table->string('pickup_location_address');
            $table->string('destination');
            $table->string('destination_address');
            $table->float('price');
            $table->float('distance');
            $table->integer('duration');
            $table->string('size')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('package_type_id')->references('id')->on('package_types');
            $table->foreign('promo_code_id')->references('id')->on('promo_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
