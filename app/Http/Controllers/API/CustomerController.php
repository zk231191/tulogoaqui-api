<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function registerNewClient(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'required|email|unique:customers',
            'street'       => 'required|string|max:255',
            'number'       => 'nullable|string|max:50',
            'city'         => 'nullable|string|max:255',
            'state'        => 'nullable|string|max:255',
            'postal_code'  => 'nullable|string|max:20',
            'rfc'          => 'nullable|string|max:20'
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::create($validated);

            $customer->address()->create([
                'street'       => $validated['street'],
                'number'       => $validated['number'] ?? null,
                'city'         => $validated['city'] ?? null,
                'state'        => $validated['state'] ?? null,
                'postal_code'  => $validated['postal_code'] ?? null,
                'rfc'          => $validated['rfc'] ?? null,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'data' => $customer->load('address')], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function searchAllClients (){
        $customers = Customer::with('address')->get();

        if ($customers->isEmpty()){
            return response()->json(['success' => false, 'message' => 'No customers found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }

    public function searchClient($id){
        $customer = Customer::with('address')->find($id);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    public function modifyAndUpdateClient (Request $request, $id){
        $customer = Customer::with('address')->find($id);

        if (!$customer){
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        $validated = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'last_name'    => 'sometimes|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'email'        => "sometimes|email|unique:customers,email,{$id}",
            'street'       => 'sometimes|string|max:255',
            'number'       => 'nullable|string|max:50',
            'city'         => 'nullable|string|max:255',
            'state'        => 'nullable|string|max:255',
            'postal_code'  => 'nullable|string|max:20',
            'rfc'          => 'nullable|string|max:20'
        ]);

        DB::beginTransaction();
        try{
            $customer->update($validated);

            if($customer->address){
                $customer->address->update($validated);
            }else{
                $customer->address->create($validated);
            }

            DB::commit();
            return response()->json(['success' => true, 'data' => $customer->load('address')]);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteClient($id){
        $customer = Customer::with('address')->find($id);

        if (!$customer){
            return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
        }

        DB::beginTransaction();
        try{

            if ($customer->address){
                $customer->address->delete();
            }
            $customer->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
