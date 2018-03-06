<?php

use Faker\Generator as Faker;

use App\Entities\User;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
// Factory for users
$factory->define(App\Entities\User::class, function (Faker $faker) {
    static  $password;
    $faker->addProvider(new Faker\Provider\ro_RO\PhoneNumber($faker));

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->premiumRatePhoneNumber,
        'blocked' => User::UNBLOCKED_USER,
        'role_id' => mt_rand(1,3),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'authentication_token' => null,

    ];
});
// Factory for role
$factory->define(App\Entities\Role::class, function (Faker $faker) {
    $records = [
        [
            'id' => 1,
            'name' => 'Administrator',
        ],
        [
            'id' => 2,
            'name' => 'Shipper',
        ],
        [
            'id' => 3,
            'name' => 'Package Owner',
        ]
    ];
    return $records;
});

// Factory for package type
$factory->define(App\Entities\PackageType::class, function (Faker $faker) {
    $records = [
        [
            'id' => 1,
            'name' => 'Small',
            'weight' => 2,
            'size' => '20x20x20',
            'price' => 2000
        ],
        [
            'id' => 2,
            'name' => 'Middle',
            'weight' => 5,
            'size' => '20x20x20',
            'price' => 4000
        ],
        [
            'id' => 3,
            'name' => 'Large',
            'weight' => 15,
            'size' => '20x20x20',
            'price' => 8000
        ]
    ];
    return $records;
});

//Factory for shippers
$factory->define(App\Entities\Shipper::class, function (Faker $faker) {
    $faker->addProvider(new Faker\Provider\en_ZA\Person($faker));

    return [
        'user_id' => 1,
        'rating' => mt_rand(0, 5),
        'latitude' => null,
        'longitude' => null,
        'avatar' => null,
        'identity_card' => $faker->idNumber,
        'is_online' => mt_rand(0, 1)
    ];
});

//Factory for package owners
$factory->define(App\Entities\PackageOwner::class, function (Faker $faker) {
    $faker->addProvider(new Faker\Provider\en_ZA\Person($faker));

    return [
        'user_id' => 1,
        'rating' => mt_rand(0, 5),
        'latitude' => null,
        'longitude' => null
    ];
});

//Factory for package owners
$factory->define(App\Entities\PackageOwner::class, function (Faker $faker) {
    $faker->addProvider(new Faker\Provider\en_ZA\Person($faker));

    return [
        'user_id' => 1,
        'rating' => mt_rand(0, 5),
        'latitude' => null,
        'longitude' => null
    ];
});

