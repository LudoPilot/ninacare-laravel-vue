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
		$superChunk = 10;
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
            // $lastUsers = User::orderBy('id', 'desc')->take($userChunk * $superChunk)->pluck('id');
            // $roleUserData = $lastUsers->map(fn($userId) => [
            //     'user_id' => $userId,
            //     'role_id' => $userRoleId,
            // ])->toArray();
            // DB::table('role_user')->insert($roleUserData);

			// Juste après avoir inséré : récupérer les nouveaux IDs
			$newUsers = User::where('id', '>', $lastInsertedId)->pluck('id');

			// Préparer les relations
			$roleUserData = $newUsers->map(fn($userId) => [
				'user_id' => $userId,
				'role_id' => $userRoleId,
			])->toArray();

			// Insérer en masse
			DB::table('role_user')->insert($roleUserData);

			// Mettre à jour le dernier ID inséré
			$lastInsertedId = User::max('id');

            $bar->advance($userChunk * $superChunk);
            unset($userData, $lastUsers, $roleUserData);
		}

		$bar->finish();
    	$this->command->info("\n✔ Users seeding complete!");
    }
}
