<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    /**
     * Method storeService
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function storeService(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'provider_id' => 'required|exists:providers,id',
            ]);

            $service = Service::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'provider_id' => $validated['provider_id'],
            ]);

            return Api::setResponse('service', $service);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
