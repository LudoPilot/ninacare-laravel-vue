<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
			'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
			//'email' => $this->faker->unique()->userName() . rand(100000, 999999) . '@fakemail.com',	// add 6-digit suffix in the address
            'email_verified_at' => now(),
            //'password' => static::$password ??= Hash::make('password'),
			'password' => 'password1234',	// faster than using Faker and hashing
            'remember_token' => Str::random(10),
			'address_id' => Address::inRandomOrder()->value('id') ?? 1,
			'created_at' => now(),
        	'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
