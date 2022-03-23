<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\School;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
  return [
    'name' => $faker->name,
    'state' => $faker->state,
    'user_id' => factory(App\User::class),
    'added_by' => function (array $name) {
      return App\User::find($name['user_id'])->name;
    },
  ];
});
