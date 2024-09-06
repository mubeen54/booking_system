<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user1 = User::first();
        $user2 = User::skip(1)->first();

        $service1 = Service::first();
        $service2 = Service::skip(1)->first();

        Booking::create([
            'user_id' => $user1->id,
            'service_id' => $service2->id,
            'title' => 'Booking for Service Two',
            'booking_date' => Carbon::now()->subDays(1),
            'status' => 'pending',
        ]);
    }
}
