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
        $chunkSize = 100;
        $total = 10000;

        for ($i = 0; $i < $total; $i += $chunkSize) {
            $addressData = Address::factory($chunkSize)
                ->make()
                ->map(fn ($address) => $address->toArray())
                ->toArray();

            Address::insert($addressData);
            //unset($addressData);
        }
    }
}
