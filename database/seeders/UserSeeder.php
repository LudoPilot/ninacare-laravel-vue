<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$userChunk = 1000;
		$superChunk = 1000;
        $totalUsers = 1_000_000;

		$addressIds = Address::pluck('id')->toArray(); // tempo


		$bar = $this->command->getOutput()->createProgressBar($totalUsers);
		$bar->start();
		$this->command->getOutput()->getOutput()->write("\n");

		$password = bcrypt('password'); // we hash the password only once
	

		// Create an admin account	
		// Login = admin@fakemail.com	|	Password = password 
	    $admin = User::create([
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

		// Attach the role ADMIN
		$adminRoleId = Role::firstOrCreate(['role_name' => Role::ADMIN])->id;
		$admin->roles()->attach($adminRoleId);


		//$userRoleId = Role::where('role_name', Role::USER)->firstOrFail()->id;
		$userRoleId = Role::firstOrCreate(['role_name' => Role::USER])->id;

		$lastInsertedId = User::max('id');

        for ($i = 0; $i < $totalUsers; $i += $userChunk * $superChunk) {
            for ($j = 0; $j < $superChunk && ($i + $j * $userChunk) < $totalUsers; $j++) {
                $userData = [];

                for ($k = 0; $k < $userChunk; $k++) {
                    $userData[] = [
                        'first_name' => fake()->firstName(),
                        'last_name' => fake()->lastName(),
                        'email' => 'user_' . uniqid() . '@fakemail.com',
                        'password' => $password,
                        'address_id' => fake()->randomElement($addressIds),
                        'email_verified_at' => now(),
                        'remember_token' => Str::random(10),
                    ];
                }

                User::insert($userData);
                $bar->advance($userChunk);
            }

            // Get the IDs
            $newUsers = User::where('id', '>', $lastInsertedId)->pluck('id');
            $roleUserData = $newUsers->map(fn($userId) => [
                'user_id' => $userId,
                'role_id' => $userRoleId,
            ])->toArray();

            DB::table('role_user')->insert($roleUserData);
            $lastInsertedId = User::max('id');
        }

		$bar->finish();
    	$this->command->info("\n✔ Users seeding complete!");
    }
}
