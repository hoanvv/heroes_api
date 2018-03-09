<?php

use Illuminate\Database\Seeder;

class PackageWeightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('package_weights')->insert([
            'id' => 1,
            'name' => '< 05 kg',
            'start_weight' => 0,
            'end_weight' => 5,
            'price' => 0
        ]);

        DB::table('package_weights')->insert([
            'id' => 2,
            'name' => '05 - 10 kg',
            'start_weight' => 5,
            'end_weight' => 10,
            'price' => 2000.0
        ]);

        DB::table('package_weights')->insert([
            'id' => 3,
            'name' => '10 - 15 kg',
            'start_weight' => 10,
            'end_weight' => 15,
            'price' => 4000.0
        ]);

        DB::table('package_weights')->insert([
            'id' => 4,
            'name' => '15 - 20 kg',
            'start_weight' => 15,
            'end_weight' => 20,
            'price' => 8000.0
        ]);

    }
}
