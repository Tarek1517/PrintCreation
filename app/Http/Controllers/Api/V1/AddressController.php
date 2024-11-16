<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AddressResource;
use App\Models\CustomerAddress;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $addresses = CustomerAddress::query()
        ->where('user_id', $request->user_id)
        ->with('area')
        ->get();

        return AddressResource::collection($addresses);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'country' => 'required',
            'city' => 'required',
            'shipping_area_id' => 'required',
            'address' => 'required', 
            'phone' => 'required',
            'email' => 'nullable',
            'user_id' => 'required'
        ]);

        $address = CustomerAddress::create($data);

        return AddressResource::make($address);
    }

    
    public function show(string $id)
    {
        $address = CustomerAddress::query()->where('id', $id)
        ->with('area')
        ->first();

        return AddressResource::make($address);
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = CustomerAddress::find($id);
        
        if($address){
            $address->delete();

            return Response::HTTP_OK;
        }
    }
}
