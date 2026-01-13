<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $branches = Branch::all();

        return response()->json($branches);
    }
}
