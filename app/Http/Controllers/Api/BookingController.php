<?php

namespace App\Http\Controllers\Api;

use App\Events\BookingConfirmed;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_id' => $request['service_id'],
            'booking_date' => $request['booking_date'],
            'title' => $request['title'],
            'status' => 'pending',
        ]);

        return response()->json($booking, 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $booking = Booking::where('id', $request->id)->first();
        return response()->json($booking);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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
        }

        return response()->json($booking);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
