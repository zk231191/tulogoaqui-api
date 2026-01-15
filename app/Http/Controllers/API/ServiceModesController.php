<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceMode;
use App\Models\ServicePriceTier;
use Illuminate\Http\Request;

class ServiceModesController extends Controller
{
    public function destroy(ServiceMode $serviceMode)
    {
        $serviceMode->delete();
        return response(null, 204);
    }

    public function update(ServiceMode $serviceMode, Request $request)
    {
        $serviceMode->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        $serviceMode->prices()->delete();

        if (isset($request->modes)) {

            $toInsert = [];

            foreach ($request->modes as $mode) {

                foreach ($mode['prices'] as $price) {

                    $toInsert[] = [
                        'service_mode_id' => $serviceMode->id,
                        'name'            => $mode['name'],
                        'description'     => $mode['description'],
                        'min_qty'         => $price['min'],
                        'max_qty'         => $price['max'],
                        'price'           => $price['price'],
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ];
                }
            }

            if (!empty($toInsert)) {
                ServicePriceTier::insert($toInsert);
            }
        }

        $service = Service::with(['modes.type', 'modes.prices'])->find($serviceMode->service_id);

        return response($service);
    }
}
