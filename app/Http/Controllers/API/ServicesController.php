<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\StoreRequest;
use App\Models\Service;
use App\Models\ServiceMode;
use App\Models\ServiceModeType;
use App\Models\ServicePriceTier;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $services = Service::with(['modes.type', 'modes.prices'])
            ->get();

        return response()->json($services);
    }

    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $service = Service::create($request->validated());
        $service->load(['modes.type', 'modes.prices']);

        return response()->json($service, 201);
    }

    public function modeTypes(): \Illuminate\Http\JsonResponse
    {
        $modeTypes = ServiceModeType::all();
        return response()->json($modeTypes);
    }

    public function storeModesAndPrices(Request $request, Service $service): \Illuminate\Http\JsonResponse
    {
        $newMode = ServiceMode::create([
            'service_id' => $service->id,
            'type_id' => $request->modeType,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        foreach ($request->modes as $mode) {
            foreach ($mode['prices'] as $price) {
                ServicePriceTier::create([
                    'service_mode_id' => $newMode->id,
                    'name' => $mode['name'],
                    'description' => $mode['description'],
                    'min_qty' => $price['min'],
                    'max_qty' => $price['max'],
                    'price' => $price['price'],
                ]);
            }
        }

        $service->load(['modes.type', 'modes.prices']);

        return response()->json($service);
    }
}
