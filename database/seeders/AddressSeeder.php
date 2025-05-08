<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddressSeeder extends Seeder
{
	protected $model = Address::class;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		Address::factory()->count(10000)->create();
    }
}
