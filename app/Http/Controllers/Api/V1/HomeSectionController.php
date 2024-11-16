<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\HomeSectionResource;
use App\Models\HomeSection;
use Illuminate\Support\Facades\File;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function App\Http\Helpers\uploadFile;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = HomeSection::query()->paginate();

        return HomeSectionResource::collection($sections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'sub_title' => 'nullable|string',
            'banner' => 'nullable|image',
            'categories' => 'nullable',
            'products' => 'nullable'
        ]);
        $filePrefix = 'banner';
        $width = 1320;
        $height = 400;
        $quality = 50;

        // save cover image
        if($request->hasFile('banner')){
            $data['banner'] = uploadFile(
                
                $request->file('banner'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        } 

        
        if($request->categories){
            $categories = $data['categories'];
            if (is_array($categories)) {
                $categories = array_map('intval', $categories); 
            }
            $data['categories'] = json_encode($categories);
        }
        if($request->products){
            $products = $data['products'];
            if (is_array($products)) {
                $products = array_map('intval', $products); 
            }
            $data['products'] = json_encode($products);
        }
        $section = HomeSection::create($data);

        return HomeSectionResource::make($section);
    }

    public function show(string $id)
    {
        $section = HomeSection::find($id);
        $section->categories = json_decode($section->categories);
        $section->products = json_decode($section->products);

        return HomeSectionResource::make($section);
    }
    
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'sub_title' => 'nullable|string',
            'banner' => 'nullable|image',
            'categories' => 'nullable',
            'products' => 'nullable',
            'order_number' => 'nullable',
        ]);

        $section = HomeSection::find($id);

        $filePrefix = 'banner';
        $width = 1320;
        $height = 400;
        $quality = 50;

        // save cover image
        if($request->hasFile('banner')){
            if (File::exists(public_path($section->banner))) {
                File::delete(public_path($section->banner));
            }
            $data['banner'] = uploadFile(
                
                $request->file('banner'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        } 


        if($request->categories){
            $categories = $request->categories;
            if (is_array($categories)) {
                $categories = array_map('intval', $categories); 
            }
            $data['categories'] = json_encode($categories);
        }
        if($request->products){ 
            $products = $request->products;
            if (is_array($products)) {
                $products = array_map('intval', $products); 
            }
            $data['products'] = json_encode($products);
        }

        $section->update($data);

        return HomeSectionResource::make($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $homeSection = HomeSection::find($id);

        if($homeSection){
            $banner = $homeSection->banner;
            if($banner)
            {
                $imagePath = str_replace('/storage','public',$banner);
                Storage::delete($imagePath);
            }
            $homeSection->delete();
        }
    }
}
