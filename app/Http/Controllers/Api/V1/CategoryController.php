<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CategoryRequest;
use App\Http\Resources\V1\Category\CategoryListResource;
use App\Http\Resources\V1\Category\CategoryParentResource;
use App\Http\Resources\V1\Category\CategoryShowResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use function App\Http\Helpers\uploadFile;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{

    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $categories = Category::query()
        ->with('parent')
        ->orderBy('order_number')
        ->pagination(); 

        return CategoryListResource::collection($categories);
    }

    public function getParent()
    {
        $categories = Category::query()
        ->where('parent_id', 0)
        ->with('children')
        ->get();

        return CategoryParentResource::collection($categories);
    }

    public function getAllCategoryList()
    {
        $categories = Category::query()
        ->select('id', 'name', 'icon')
        ->get();

        return response()->json($categories);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = str::slug($data['name']);

        $filePrefix = $data['slug'];
        $width = 200;
        $height = 200;
        $quality = 50;

        // save icon image
        if($request->hasFile('icon')){
            $data['icon'] = uploadFile(

                $request->file('icon'),
                $filePrefix.'icon',
                $width,
                $height,
                $quality
            );
        }

        // save banner image
        if($request->hasFile('banner')){
            $data['banner'] = uploadFile(

                $request->file('banner'),
                $filePrefix .'banner',
                1320, //width
                400, // height
                $quality
            );
        }

        $category = Category::create($data);

        return CategoryShowResource::make($category);
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return CategoryShowResource::make($category);
    }

    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();
        $data['slug'] = str::slug($data['name']);
        
        $filePrefix = $data['slug'];
        $width = 200;
        $height = 200;
        $quality = 50;

        // update icon image
        if($request->hasFile('icon')){
            $data['icon'] = uploadFile(
                $request->file(key: 'icon'),
                $filePrefix.'icon',
                $width,
                $height,
                $quality
            );
        } 

        
        // update banner image
        if($request->hasFile('banner')){
            $data['banner'] = uploadFile(
                $request->file('banner'),
                $filePrefix.'banner',
                1320, //width
                400, // height
                $quality
            );
        } else{
            $data['banner'] = $category->banner;
        }
        $category->update($data);       

        return CategoryShowResource::make($category);
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if($category)
        {
            $image = $category->image;
            if($image){
                $imagePath = str_replace('/storage','public',$image);
                Storage::delete($imagePath);
            }
            $category->delete();

            return Response::HTTP_OK;
        }
    }
}