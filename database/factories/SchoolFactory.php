<?php

namespace Database\Factories;

use \App\Models\School;
use \App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SchoolFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = School::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name,
      'state' => $this->faker->state,
      'user_id' => User::factory()->create(),
      'added_by' => function (array $name) {
        return User::find($name['user_id'])->name;
      },
    ];
  }
}
