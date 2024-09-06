<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
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
        try {
            $latitude = $request['latitude'];
            $longitude = $request['longitude'];
            $range = 25;

            $providers = Provider::select(DB::raw("
                id, name, latitude, longitude,
                ( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance
            "))
                ->having('distance', '<=', $range)
                ->setBindings([$latitude, $longitude, $latitude])
                ->orderBy('distance', 'asc')
                ->get();

            return Api::setResponse('providers', $providers);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    /**
     * Method addProvider
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function addProvider(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'range' => 'required|numeric',
            ]);

            $provider = Provider::create([
                'name' => $validated['name'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'range' => $validated['range'],
            ]);

            return Api::setResponse('provider', $provider);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
