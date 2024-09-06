<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\BookingController;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store_creates_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $bookingData = Booking::factory()->make([
            'user_id' => $user->id,
            'service_id' => $service->id,
        ])->toArray();

        $controller = new BookingController();

        $response = $controller->store(new Request($bookingData));

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'service_id' => $bookingData['service_id'],
            'booking_date' => \Carbon\Carbon::parse($bookingData['booking_date'])->format('Y-m-d H:i:s'),
            'title' => $bookingData['title'],
            'status' => 'pending',
        ]);
    }

    /**
     * Method test_index_returns_all_bookings
     *
     * @return void
     */
    public function test_index_returns_all_bookings()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $bookings = Booking::factory()->count(3)->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
        ]);

        $controller = new BookingController();

        $response = $controller->index();

        $this->assertCount(3, $response);
        $this->assertEquals($bookings->toArray(), $response->toArray());
    }

    /**
     * Method test_show_returns_booking
     *
     * @return void
     */
    public function test_show_returns_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
        ]);

        $controller = new BookingController();

        $response = $controller->show(new Request(['id' => $booking->id]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($booking->toArray(), $response->getData(true));
    }

    /**
     * Method test_update_booking
     *
     * @return void
     */
    public function test_update_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        $updatedData = [
            'service_id' => $service->id,
            'booking_date' => '2024-09-10',
            'title' => 'Updated Booking Title',
            'status' => 'confirmed',
        ];

        $controller = new BookingController();

        $response = $controller->update(new Request($updatedData), $booking->id);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'service_id' => $updatedData['service_id'],
            'booking_date' => \Carbon\Carbon::parse($updatedData['booking_date'])->format('Y-m-d H:i:s'), // Format date for comparison
            'title' => $updatedData['title'],
            'status' => $updatedData['status'],
        ]);
    }

    /**
     * Method test_destroy_deletes_booking
     *
     * @return void
     */
    public function test_destroy_deletes_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $service = Service::factory()->create();

        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'service_id' => $service->id,
        ]);

        $controller = new BookingController();

        $response = $controller->destroy($booking->id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'Booking deleted successfully'], $response->getData(true));

        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
        ]);
    }
}
