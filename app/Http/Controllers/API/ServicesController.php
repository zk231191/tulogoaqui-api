<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\StoreRequest;
use App\Models\Service;
use App\Models\ServiceModeType;
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
}
