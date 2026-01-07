<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolesPermissions\CreateRoleRequest;
use App\Http\Requests\RolesPermissions\UpdatePermissionsRequest;
use App\Http\Requests\RolesPermissions\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $role = Role::with('permissions')->get();
        $permission = Permission::all();

        return response()->json([
            'roles' => $role,
            'permissions' => $permission
        ]);
    }

    public function store(CreateRoleRequest $request): \Illuminate\Http\JsonResponse
    {
        $role = Role::create($request->validated());

        $role->load('permissions');

        return response()->json($role);
    }

    public function update(Role $role, UpdateRoleRequest $request): \Illuminate\Http\JsonResponse
    {
        $role->update($request->validated());

        $role->load('permissions');

        return response()->json($role);
    }

    public function updatePermissions(Role $role, UpdatePermissionsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $role->syncPermissions($data['permissions']);

        $role->load('permissions');

        return response()->json($role);
    }

    public function destroy(Role $role): \Illuminate\Http\JsonResponse
    {
        // Remove all direct permissions assigned to the role
        $role->permissions()->detach();

        // Remove all model_has_roles entries with this role
        \DB::table('model_has_roles')->where('role_id', $role->id)->delete();

        // Remove all role_has_permissions entries
        \DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

        // Delete the role itself
        $role->delete();

        return response()->json(['success' => true]);
    }
}
