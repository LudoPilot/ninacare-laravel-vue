<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$chunkSize = 1000;
		$totalUsers = 1000000;

		for ($i = 0; $i < $totalUsers; $i += $chunkSize) {
			\App\Models\User::factory()
				->count($chunkSize)
				->create()
				->each(function ($user) {
					$user->address()->save(\App\Models\Address::factory()->make());
				});
		}
    }
}
