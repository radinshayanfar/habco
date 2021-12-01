<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fname' => $this->faker->firstName(),
            'lname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->freeEmail(),
            'national_number' => $this->faker->unique()->numerify(str_repeat('#', 10)),
            'address' => $this->faker->address(),
            'phone' => $this->faker->unique()->regexify('9891\d{8}'),
            'age' => $this->faker->randomNumber(2, false),
            'gender' => Arr::random(['male', 'female']),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->createRoleRecord();
        });
    }
}
