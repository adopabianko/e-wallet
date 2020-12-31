<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $email = $this->faker->unique()->safeEmail;

        return [
            'name' => $this->faker->name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make('secret123'), // password
            'remember_token' => Str::random(10),
            'token' => Hash::make($email),
            'phone_number' => $this->faker->randomDigit
        ];
    }
}
