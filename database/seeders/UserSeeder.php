<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$totalUsers = 1_000_000;
		$batchSize = 5000; 
		$password = bcrypt('password');
		$rememberToken = Str::random(10);
		$addressIds = Address::pluck('id')->toArray();

		$admin = User::create([
			'first_name' => 'Admin',
			'last_name' => 'User',
			'email' => 'admin@fakemail.com',
			'password' => $password,
			'address_id' => fake()->randomElement($addressIds),
			'email_verified_at' => now(),
			'remember_token' => $rememberToken,
		]);

		$adminRoleId = Role::firstOrCreate(['role_name' => Role::ADMIN])->id;
		$admin->roles()->attach($adminRoleId);

		$userRoleId = Role::firstOrCreate(['role_name' => Role::USER])->id;

		$bar = $this->command->getOutput()->createProgressBar($totalUsers);
		$bar->start();
		$this->command->getOutput()->getOutput()->write("\n");

		$nextId = 2;

		for ($i = 1; $i <= $totalUsers; $i += $batchSize) {
			$users   = [];
			$pivots  = [];

			for ($j = 0; $j < $batchSize && ($i + $j) <= $totalUsers; $j++) {
				$users[] = [
					'id'                => $nextId + $j,
					'first_name'        => fake()->firstName(),
					'last_name'         => fake()->lastName(),
					'email'             => "user_" . ($i + $j) . "@fakemail.com",
					'password'          => $password,
					'address_id'        => fake()->randomElement($addressIds),
					'email_verified_at' => now(),
					'remember_token'    => Str::random(10),
					'created_at'        => now(),
					'updated_at'        => now(),
				];

				$pivots[] = [
					'user_id' => $nextId + $j,
					'role_id' => $userRoleId,
				];
			}

			// on insère en bulk
			DB::table('users')->insert($users);
			DB::table('role_user')->insert($pivots);

			// on met à jour l’ID de départ pour la batch suivante
			$nextId += count($users);

			$bar->advance(count($users));
		}

		$bar->finish();
		$this->command->info("\n✔ Users seeding complete!");
	}
}
