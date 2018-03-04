<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
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
            $table->integer('package_owner_id')->unsigned();
            $table->integer('package_type_id')->unsigned();
            $table->integer('promo_code_id')->unsigned();
            $table->string('receiver_name');
            $table->string('phone');
            $table->string('pickup_location');
            $table->string('destination');
            $table->text('note')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('package_owner_id')->references('id')->on('package_owners');
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
