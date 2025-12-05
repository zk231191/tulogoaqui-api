<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    public function store(CreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $customer = Customer::create($request->validated());

        return response()->json($customer);
    }

    public function show(Customer $customer): \Illuminate\Http\JsonResponse
    {
        return response()->json($customer);
    }

    public function update(Customer $customer, UpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $customer->update($request->validated());

        return response()->json($customer);
    }

    public function destroy(Customer $customer): \Illuminate\Http\JsonResponse
    {
        $customer->delete();

        return response()->json([], 204);
    }
}
