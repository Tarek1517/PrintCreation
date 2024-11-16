<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ShippingAreaRequest;
use App\Http\Resources\V1\ShippingAreaResource;
use App\Models\ShippingArea;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShippingAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = ShippingArea::query()->get();

        return ShippingAreaResource::collection($areas);
    }

    public function getAllShippingList()
    {
        $areas = ShippingArea::query()->get();

        return ShippingAreaResource::collection($areas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingAreaRequest $request)
    {
        $data = $request->validated();
        $shippingArea = ShippingArea::create($data);

        ShippingAreaResource::make($shippingArea);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shippingArea = ShippingArea::find($id);

        return ShippingAreaResource::make($shippingArea);
    }

    /**
     * Update the specified resource in storage.
     */

   
    public function update(ShippingAreaRequest $request, string $id)
    {
        $shippingArea = ShippingArea::find($id);
        $data = $request->validated();
       
        $shippingArea->update($data);

        return ShippingAreaResource::make($shippingArea);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = ShippingArea::find($id);

        if($area)
        {
            $area->delete();
            return Response::HTTP_OK;
        }
    }
}
