<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function register(StoreRequest $request)
    {
        $validated = $request->validated();
        $factureRequired = (bool) ($validated['facture_required'] ?? false);

        DB::beginTransaction();
        try {
            $customer = Customer::create([
                'name'               => $validated['name'],
                'paternal_last_name' => $validated['paternal_last_name'] ?? null,
                'maternal_last_name' => $validated['maternal_last_name'] ?? null,
                'phone'              => $validated['phone'],
                'email'              => $validated['email'],
                'facture_required'   => $factureRequired,
            ]);

            if ($factureRequired) {
                $customer->address()->create([
                    'street'        => $validated['street'] ?? null,
                    'number'        => $validated['number'] ?? null,
                    'neighborhood'  => $validated['neighborhood'] ?? null,
                    'city'          => $validated['city'] ?? null,
                    'state'         => $validated['state'] ?? null,
                    'postal_code'   => $validated['postal_code'] ?? null,
                    'rfc'           => $validated['rfc'] ?? null,
                    'business_name' => $validated['business_name'] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'data' => $customer->load('address')], 201);
        } catch (Exception $e) {
            DB::rollBack();
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

        DB::beginTransaction();
        try {
            $customer->update($customerData);

            if ($factureRequired) {
                if ($customer->address) {
                    $customer->address->update($addressData);
                } else {
                    $customer->address()->create($addressData);
                }
            } else {
                if ($customer->address) {
                    $customer->address->delete();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'data' => $customer->load('address')]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function delete(Customer $customer)
    {
        DB::beginTransaction();
        try {
            if ($customer->address) {
                $customer->address->delete();
            }
            $customer->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
