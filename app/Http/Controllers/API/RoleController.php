<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $roles = Role::with('permissions')->get();

        return response()->json($roles);
    }
}
