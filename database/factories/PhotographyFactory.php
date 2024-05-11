<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\Photography;
use App\Models\PointOfInterest;
use App\Models\ThematicArea;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Photography::class, function (Faker $faker) {
    return [
        'route' => 'https://images.pexels.com/photos/303383/pexels-photo-303383.jpeg?auto=compress&cs=tinysrgb&w=600',
        'order' => $faker->randomDigit,
        'point_of_interest_id' => $faker->randomElement(PointOfInterest::all()->pluck('id')->toArray()),
        'thematic_area_id' => $faker->randomElement(ThematicArea::all()->pluck('id')->toArray()),
        'creator' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'updater' => null,
        'updated_at' => null,
    ];
});
