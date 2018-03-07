<?php

use Illuminate\Database\Seeder;

class PackageTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('package_types')->insert([
            'id' => 1,
            'name' => 'Small',
            'weight' => 2,
            'size' => '15x15x15',
            'price' => 2000
        ]);

        DB::table('package_types')->insert([
            'id' => 2,
            'name' => 'Middle',
            'weight' => 5,
            'size' => '30x30x30',
            'price' => 4000
        ]);

        DB::table('package_types')->insert([
            'id' => 3,
            'name' => 'Large',
            'weight' => 15,
            'size' => '50x50x50',
            'price' => 8000
        ]);
    }
}
