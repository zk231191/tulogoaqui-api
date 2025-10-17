<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\StoreRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $services = Service::with(['modes.sizes.priceTiers'])
            ->get();

        return response()->json($services);
    }

    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $service = Service::create($request->validated());

        return response()->json($service, 201);
    }
}
