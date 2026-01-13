<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = User::with(['roles', 'permissions'])->get();

        return response()->json($users);
    }

    public function store(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(['name', 'username', 'email', 'password']);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $user->assignRole($request->role_name);

        $user->load(['roles', 'permissions']);

        return response()->json($user);
    }

    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        return response()->json($user);
    }

    public function update(UpdateRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(['name', 'username', 'email', 'password']);

        unset($data['password']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->filled('role_name')) {
            $user->syncRoles([$request->role_name]);
        }

        $user->load(['roles', 'permissions']);

        return response()->json($user);
    }

    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();

        return response()->json([], 204);
    }

    public function changePassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only(['password']);

        $user = auth()->user();
        $user->password = Hash::make($data['password']);
        $user->save();

        return response()->json([], 204);
    }
}
