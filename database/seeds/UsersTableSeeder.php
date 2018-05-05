<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Entities\User::class, 150)->create()->each(function ($user) {
            switch ($user->role_id) {
                case 2:
                    $user->shipper()->save(factory(App\Entities\Shipper::class)->make([
                        'user_id' => $user->id,
                    ]));
                    break;
                case 3:
                    $user->packageOwner()->save(factory(App\Entities\PackageOwner::class)->make([
                        'user_id' => $user->id,
                    ]));
                    break;
            }

        });
    }
}
