<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $provider1 = Provider::where('name', 'Provider One')->first();
        $provider2 = Provider::where('name', 'Provider Two')->first();

        Service::create([
            'name' => 'Service One',
            'description' => 'This is the first service description',
            'price' => 100,
            'provider_id' => $provider1->id,
        ]);

        Service::create([
            'name' => 'Service Two',
            'description' => 'This is the second service description',
            'price' => 150,
            'provider_id' => $provider1->id,
        ]);

        Service::create([
            'name' => 'Service Three',
            'description' => 'This is the third service description',
            'price' => 200,
            'provider_id' => $provider2->id,
        ]);

        Service::create([
            'name' => 'Service Four',
            'description' => 'This is the fourth service description',
            'price' => 250,
            'provider_id' => $provider2->id,
        ]);
    }
}
