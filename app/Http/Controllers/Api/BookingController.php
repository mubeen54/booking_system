<?php

namespace App\Http\Controllers\Api;

use App\Events\BookingConfirmed;
use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $bookings = Booking::all();
            return Api::setResponse('bookings', $bookings);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'booking_date' => 'required|date',
                'title' => 'required|string|max:255',
            ]);

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'service_id' => $validated['service_id'],
                'booking_date' => $validated['booking_date'],
                'title' => $validated['title'],
                'status' => 'pending',
            ]);

            return Api::setResponse('booking', $booking);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->id);
            return Api::setResponse('booking', $booking);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            $validated = $request->validate([
                'service_id' => 'sometimes|required|exists:services,id',
                'booking_date' => 'sometimes|required|date',
                'title' => 'sometimes|required|string|max:255',
                'status' => 'sometimes|required|in:pending,confirmed,cancelled',
            ]);

            $booking->update($validated);

            if ($booking->status === 'confirmed') {
                event(new BookingConfirmed($booking));
                Log::info('BookingConfirmed event fired for booking ID: ' . $booking->id);
            }

            return Api::setResponse('booking', $booking);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            $booking->delete();
            return Api::setMessage('Booking deleted successfully');
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
