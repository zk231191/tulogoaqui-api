<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SatRegime;
use Illuminate\Http\Request;

class FiscalRegimeController extends Controller
{
    public function index()
    {
        return SatRegime::with(['cfdiUses'])->get();
    }
}
