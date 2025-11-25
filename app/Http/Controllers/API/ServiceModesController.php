<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceMode;
use Illuminate\Http\Request;

class ServiceModesController extends Controller
{
    public function destroy(ServiceMode $serviceMode)
    {
        $serviceMode->delete();
        return response(null, 204);
    }
}
