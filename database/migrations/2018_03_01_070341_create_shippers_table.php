<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Entities\User;
use App\Entities\Shipper;

class CreateShippersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->float('rating')->default(User::DEFAULT_RATING);
            $table->string('avatar')->nullable();
            $table->string('identity_card');
            $table->integer('is_online')->default(Shipper::OFFLINE_SHIP);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippers');
    }
}
