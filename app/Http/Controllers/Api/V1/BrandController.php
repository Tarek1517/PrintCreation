<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\V1\Brand\BrandListResource;
use App\Http\Resources\V1\Brand\BrandShowResource;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use illuminate\Support\Str;
use function App\Http\Helpers\uploadFile;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::query()
        ->orderBy('order_number')
        ->pagination(); 
        
        return BrandListResource::collection($brands);
    }

    
    public function getAllBrandList()
    {
        $brands = Brand::query()
        ->select('id', 'slug', 'name', 'logo')
        ->get();

        return BrandListResource::collection($brands);
    }

    public function store(BrandRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $filePrefix = $data['slug'];
        $width = 400;
        $height = 400;
        $quality = 50;

        // save cover image
        if($request->hasFile('logo')){
            $data['logo'] = uploadFile(
                
                $request->file('logo'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        }

        // save banner image
        if($request->hasFile('banner')){
            $data['banner'] = uploadFile(
                
                $request->file('banner'),
                $filePrefix.'banner',
                1320,
                400,
                $quality
            );
        }

        $brand = Brand::create($data);

        return BrandShowResource::make($brand);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return BrandShowResource::make(Brand::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): BrandShowResource
    {
        $brand = Brand::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255,',
            'slug' => 'nullable|string|max:255|,',
            'logo' => 'nullable|mimes:png,jpg,jpeg,webp',
            'order_number' => 'required:integer',
            'banner' => 'nullable|mimes:png,jpg,jpeg,webp',
            'description' => 'nullable|string',
            'status' => 'required',  
        ]);

        $data['slug'] = Str::slug($data['name']);

        $filePrefix = $data['slug'];
        $width = 400;
        $height = 400;
        $quality = 50;

        // save cover image
        if($request->hasFile('logo')){
            $data['logo'] = uploadFile(
                
                $request->file('logo'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        }

        // save banner image
        if($request->hasFile('banner')){
            $data['banner'] = uploadFile(
                
                $request->file('banner'),
                $filePrefix.'banner',
                1320,
                400,
                $quality
            );
        }
        $brand->update($data);

        return BrandShowResource::make($brand);
    }

    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        if($brand)
        {
            $image = $brand->image;
            if($image){
                $imagePath = str_replace('/storage','public',$image);
                Storage::delete($imagePath);
            }
            $brand->delete();

            return Response::HTTP_OK;
        }
    }
}
