<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Throwable;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function register(StoreRequest $request)
    {
        $validated = $request->validated();
        $factureRequired = (bool) ($validated['facture_required'] ?? false);

        try {
            DB::transaction(function () use ($validated, $factureRequired, &$customer) {
                $customer = Customer::create([
                    'name'               => $validated['name'],
                    'paternal_last_name' => $validated['paternal_last_name'] ?? null,
                    'maternal_last_name' => $validated['maternal_last_name'] ?? null,
                    'phone'              => $validated['phone'],
                    'email'              => $validated['email'],
                    'facture_required'   => $factureRequired,
                ]);

                if ($factureRequired) {
                    $addressData = [
                        'street'        => $validated['street'] ?? null,
                        'number'        => $validated['number'] ?? null,
                        'neighborhood'  => $validated['neighborhood'] ?? null,
                        'city'          => $validated['city'] ?? null,
                        'state'         => $validated['state'] ?? null,
                        'postal_code'   => $validated['postal_code'] ?? null,
                        'rfc'           => $validated['rfc'] ?? null,
                        'business_name' => $validated['business_name'] ?? null,
                    ];

                    $customer->address()->updateOrCreate([], $addressData);
                }
            });

            return response()->json(['success' => true, 'data' => $customer->load('address')], 201);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function showAll()
    {
        $customers = Customer::with('address')->get();
        return response()->json(['success' => true, 'data' => $customers]);
    }

    public function show(Customer $customer)
    {
        return response()->json(['success' => true, 'data' => $customer->load('address')]);
    }

    public function update(UpdateRequest $request, Customer $customer)
    {
        $customer->load('address');

        $validated = $request->validated();
        $incomingFacture = array_key_exists('facture_required', $validated) ? (bool)$validated['facture_required'] : null;
        $factureRequired = $incomingFacture !== null ? $incomingFacture : (bool) $customer->facture_required;

        $customerData = [
            'name'               => $validated['name'],
            'paternal_last_name' => $validated['paternal_last_name'] ?? null,
            'maternal_last_name' => $validated['maternal_last_name'] ?? null,
            'phone'              => $validated['phone'],
            'email'              => $validated['email'],
            'facture_required'   => $factureRequired,
        ];

        $addressData = [
            'street'        => $validated['street'] ?? null,
            'number'        => $validated['number'] ?? null,
            'neighborhood'  => $validated['neighborhood'] ?? null,
            'city'          => $validated['city'] ?? null,
            'state'         => $validated['state'] ?? null,
            'postal_code'   => $validated['postal_code'] ?? null,
            'rfc'           => $validated['rfc'] ?? null,
            'business_name' => $validated['business_name'] ?? null,
        ];

        try {
            DB::transaction(function () use ($customer, $customerData, $factureRequired, $addressData) {
                $customer->update($customerData);

                if ($factureRequired) {
                    $customer->address()->updateOrCreate([], $addressData);
                } else {
                    // si hay una dirección y ahora no requiere factura, la eliminamos (soft delete si aplica)
                    if ($customer->address) {
                        $customer->address()->delete();
                    }
                }
            });

            return response()->json(['success' => true, 'data' => $customer->load('address')]);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function delete(Customer $customer)
    {
        try {
            DB::transaction(function () use ($customer) {
                if ($customer->address) {
                    $customer->address()->delete();
                }
                $customer->delete();
            });

            return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
