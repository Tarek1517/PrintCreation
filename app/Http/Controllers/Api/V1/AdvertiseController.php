<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AdvertiseResource;
use Illuminate\Http\Request;
use App\Models\Advertise;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class AdvertiseController extends Controller
{
    public function index(Request $request)
    {
        $advertieses = Advertise::query()
                    ->whereLinke(['url'], $request->input('search'))
                    ->paginate(12);

        return AdvertiseResource::collection($advertieses);            
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'required|mimes:png,jpg,jpeg,webp|between:300, 900',
            'products' => 'required',
        ]);

        if($request->hasFile('image')){
            $path ='/storage/'.$request->file('image')->store('uploads','public');
            $data['image'] = $path;
        }
        $advertise = Advertise::create($data);

        return  AdvertiseResource::make($advertise);
    }

    public function update(Request $request, string $id)
    {
        $advertise = Advertise::fiindOrFail($id);

        $data = $request->validate([
            'title' => 'required|string',
            'image' => 'required|mimes:png,jpg,jpeg,webp|between:300, 900',
            'products' => 'required',
        ]);

        if($request->hasFile('image')){
            $path ='/storage/'.$request->file('image')->store('uploads','public');
            $data['image'] = $path;
        }
        $advertise = $advertise->update($data);

        return  AdvertiseResource::make($advertise);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advertise = Advertise::findOrFail($id);
        if($advertise){
            $image = $advertise->image;
            if($image){
                $imagePath = str_replace('/storage', 'public', $image);
                Storage::delete($imagePath);
            }
            $advertise->delete();

            return Response::HTTP_OK;
        }
    }
}