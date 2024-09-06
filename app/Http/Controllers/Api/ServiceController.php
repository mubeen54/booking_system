<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Method search
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $radius = 25;
        $services = Service::selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance", [$validated['lat'], $validated['lng'], $validated['lat']])
            ->having("distance", "<", $radius)
            ->get();

        return response()->json($services);
    }

    /**
     * Method storeService
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function storeService(Request $request)
    {
        $service = Service::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'provider_id' => $request['provider_id'],
        ]);

        return response()->json($service, 201);
    }
}
