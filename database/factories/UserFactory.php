<?php
use Faker\Generator as Faker;

use App\Entities\User;
use Faker\Provider\ro_RO as FakerRoRO;
use Faker\Provider\en_ZA as FakerEnZA;
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
    $faker->addProvider(new FakerRoRO\PhoneNumber($faker));
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

//Factory for shippers
$factory->define(App\Entities\Shipper::class, function (Faker $faker) {
    $faker->addProvider(new FakerEnZA\Person($faker));
    return [
        'user_id' => 1,
        'rating' => mt_rand(0, 5),
        'latitude' => 16.0536514,
        'longitude' => 108.2175914,
        'avatar' => null,
        'identity_card' => $faker->idNumber,
        'is_online' => mt_rand(0, 1)
    ];
});

//Factory for package owners
$factory->define(App\Entities\PackageOwner::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'rating' => mt_rand(0, 5),
        'latitude' => 16.0536514,
        'longitude' => 108.2175914
    ];
});

