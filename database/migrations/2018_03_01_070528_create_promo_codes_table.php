<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Entities\PromoCode;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gift_code')->unique();
            $table->float('discount');
            $table->integer('validity');
            $table->dateTime('activation_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->integer('usage_limit');
            $table->integer('status')->default(PromoCode::AVAILABLE_PROMOCODE);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('promo_codes');
    }
}
