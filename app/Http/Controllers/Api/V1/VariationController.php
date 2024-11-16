<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\V1\Product\VariationResource;
use Illuminate\Support\Facades\Storage;

class VariationController extends Controller
{
    public function index(Request $request) :\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $variations = Variation::query()
        ->select('id', 'name', 'slug', 'created_at')
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        return VariationResource::collection($variations);
    }

    public function allAttributeList()
    {
        $attributes = Variation::query()
        ->select('id', 'name', 'slug')
        ->get();

        return VariationResource::collection($attributes);
    }

    public function store(Request $request) :VariationResource
    {
        
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp'
        ]);
        $data['slug'] = Str::slug($data['name']);

        if($request->hasFile('image')){
            $path ='/storage/'.$request->file('image')->store('uploads','public');
            $data['image'] = $path;
        }

        $variation = Variation::create($data);

        return VariationResource::make($variation);
    }


    public function update(Request $request, string $id)
    {
        $variation = Variation::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp'
        ]);

        $data['slug'] = Str::slug($data['name']);

        if($request->hasFile('image')){
            if ($variation->icon) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $variation->icon));
            }
            $path = '/storage/' . $request->file('image')->store('uploads', 'public');
            $data['image'] = $path;
        }

        $variation->update($data);

        return VariationResource::make($variation);
    }

    public function destroy(string $id)
    {
        $productAttribute = Variation::findOrFail($id);

        if($productAttribute){
            $productAttribute->delete();

            return Response::HTTP_OK;
        }
    }
}