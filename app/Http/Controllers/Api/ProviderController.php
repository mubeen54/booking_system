<?php

namespace App\Http\Controllers\Api;

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

        return response()->json($providers);
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

        $provider = Provider::create([
            'name' => $request['name'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
            'range' => $request['range'],
        ]);

        return response()->json($provider, 201);
    }
}
