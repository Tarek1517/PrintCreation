<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CustomerRequest;
use App\Http\Resources\V1\Customer\CustomerListResource;
use App\Http\Resources\V1\Customer\CustomerShowResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()
        ->with('addresses')
        ->whereLike(['name', 'phone', 'email'], $request->input('search'))
        ->sortBy()
        ->pagination(); 

        return CustomerListResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();
        $customer = User::create($data);

        return CustomerShowResource::make($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = User::query()->where('id', $id)->with('addresses', 'order');

        CustomerShowResource::make($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = User::find($id);
        if($customer){
            $addresses = $customer->addrresses;
            if($addresses) {
                $addresses->delete();
            }
            $customer->delete();

            return Response::HTTP_OK;
        }
    }
}