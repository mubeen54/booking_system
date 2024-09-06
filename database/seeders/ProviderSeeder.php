<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Provider::create([
            'name' => 'Provider One',
            'latitude' => '37.7749',
            'longitude' => '-122.4194',
            'range' => 20,
        ]);

        Provider::create([
            'name' => 'Provider Two',
            'latitude' => '34.0522',
            'longitude' => '-118.2437',
            'range' => 15,
        ]);

        Provider::create([
            'name' => 'Provider Three',
            'latitude' => '51.5074',
            'longitude' => '-0.1278',
            'range' => 25,
        ]);
    }
}
