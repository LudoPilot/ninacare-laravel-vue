<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$userChunk = 1000;
		$superChunk = 10;
        $totalUsers = 10_000_000;

		$addressIds = Address::pluck('id')->toArray(); // tempo


		$bar = $this->command->getOutput()->createProgressBar($totalUsers);
		$bar->start();
		$this->command->getOutput()->getOutput()->write("\n");

		$password = bcrypt('password'); // we hash the password only once
	

		// Create an admin account	
		// Login = admin@fakemail.com	|	Password = password 
	    User::create([
			'first_name'        => 'Admin',
			'last_name'         => 'User',
			'email'             => 'admin@fakemail.com',
			'password'          => $password,
			'address_id'        => fake()->randomElement($addressIds),
			'email_verified_at' => now(),
			'remember_token'    => Str::random(10),
			'created_at'        => now(),
			'updated_at'        => now(),
		]);

		for ($i = 0; $i < $totalUsers; $i += $userChunk * $superChunk) {

			$userData = [];

			for ($j = 0; $j < $superChunk; $j++) {
                $userData[] = [
                    'first_name'        => fake()->firstName(),
                    'last_name'         => fake()->lastName(),
                    'email'             => 'user_' . uniqid() . '@fakemail.com',
                    'password'          => $password,
                    'address_id'        => fake()->randomElement($addressIds),
                    'email_verified_at' => now(),
                    'remember_token'    => Str::random(10),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];				
			}

			User::insert($userData);
			$bar->advance($userChunk * $superChunk);
			unset($userData);
		}

		$bar->finish();
    	$this->command->info("\n✔ Users seeding complete!");
    }
}
