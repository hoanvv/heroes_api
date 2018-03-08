<?php

use Illuminate\Database\Seeder;

class PromoCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('promo_codes')->insert([
            'id' => 1,
            'gift_code' => str_random(20),
            'discount' => 0,
            'validity' => 0,
            'activation_date' => null,
            'expiry_date' => null,
            'usage_limit' => null,
            'status' => \App\Entities\PromoCode::AVAILABLE_PROMOCODE,
            'description' => 'Default Promocode',
        ]);

        DB::table('promo_codes')->insert([
            'id' => 2,
            'gift_code' => str_random(20),
            'discount' => 20.0,
            'validity' => 0,
            'activation_date' => null,
            'expiry_date' => null,
            'usage_limit' => 100,
            'status' => \App\Entities\PromoCode::AVAILABLE_PROMOCODE,
            'description' => 'Default Promocode',
        ]);

        DB::table('promo_codes')->insert([
            'id' => 3,
            'gift_code' => str_random(20),
            'discount' => 10.0,
            'validity' => 0,
            'activation_date' => null,
            'expiry_date' => null,
            'usage_limit' => 100,
            'status' => \App\Entities\PromoCode::UNAVAILABLE_PROMOCODE,
            'description' => 'Default Promocode',
        ]);
    }
}
