<?php

use Illuminate\Database\Seeder;

use App\Entities\PackageType;

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
            'name' => '< 03 kg',
            'optional_package' => PackageType::OPTIONAL_PACKAGE,
            'start_weight' => 0,
            'end_weight' => 3,
            'price' => 0
        ]);

        DB::table('package_types')->insert([
            'id' => 2,
            'name' => '03 - 10 kg',
            'optional_package' => PackageType::OPTIONAL_PACKAGE,
            'start_weight' => 3,
            'end_weight' => 10,
            'price' => 2000.0
        ]);

        DB::table('package_types')->insert([
            'id' => 3,
            'name' => '10 - 15 kg',
            'optional_package' => PackageType::OPTIONAL_PACKAGE,
            'start_weight' => 10,
            'end_weight' => 15,
            'price' => 4000.0
        ]);

        DB::table('package_types')->insert([
            'id' => 4,
            'name' => '15 - 20 kg',
            'optional_package' => PackageType::OPTIONAL_PACKAGE,
            'start_weight' => 15,
            'end_weight' => 20,
            'price' => 8000.0
        ]);

        DB::table('package_types')->insert([
            'id' => 5,
            'name' => 'Box: Size < 20x20x20 or Weight < 3 kg ',
            'optional_package' => PackageType::NORMAL_PACKAGE,
            'start_weight' => null,
            'end_weight' => null,
            'price' => 0
        ]);

        DB::table('package_types')->insert([
            'id' => 6,
            'name' => 'Documents',
            'optional_package' => PackageType::NORMAL_PACKAGE,
            'start_weight' => null,
            'end_weight' => null,
            'price' => 0
        ]);

        DB::table('package_types')->insert([
            'id' => 7,
            'name' => 'Mobile',
            'optional_package' => PackageType::NORMAL_PACKAGE,
            'start_weight' => null,
            'end_weight' => null,
            'price' => 0
        ]);

        DB::table('package_types')->insert([
            'id' => 8,
            'name' => 'Flower bouquet',
            'optional_package' => PackageType::NORMAL_PACKAGE,
            'start_weight' => null,
            'end_weight' => null,
            'price' => 0
        ]);

        DB::table('package_types')->insert([
            'id' => 9,
            'name' => 'Laptop',
            'optional_package' => PackageType::NORMAL_PACKAGE,
            'start_weight' => null,
            'end_weight' => null,
            'price' => 0
        ]);
    }
}
