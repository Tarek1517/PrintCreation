<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductRequest;
use App\Http\Resources\V1\Product\ProductShowResource;
use App\Http\Resources\V1\Product\ProductListResource;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Variation;
use Illuminate\Support\Facades\File;

use function App\Http\Helpers\showPrices;
use function App\Http\Helpers\getSetting;
use function App\Http\Helpers\uploadFile;
use function App\Http\Helpers\multipleFileUpload;

class ProductController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $products = Product::query()
        ->with('category', 'brand', 'stocks')
        ->paginate(40);
        return ProductListResource::collection($products);
    }

    public function getAllProductList()
    {
        $products = Product::query()
        ->select('id', 'slug', 'title', 'price', 'discount_price', 'cover_image','hover_image')
        ->get();

        return ProductListResource::collection($products);
    }

    public function store(ProductRequest $request): ProductShowResource
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['title']);
        if(isset($data['key_features'])){
            $data['key_features'] = json_encode($data['key_features']);
        }
        $filePrefix = $data['slug'];
        $width = 500;
        $height = 530;
        $quality = 50;

        // save cover image
        if($request->hasFile('cover_image')){
            $data['cover_image'] = uploadFile(
                
                $request->file('cover_image'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        }

        // save hover image
        if($request->hasFile('hover_image')){
            $data['hover_image'] = uploadFile(

                $request->file('hover_image'),
                $filePrefix.'hover_image',
                $width,
                $height,
                $quality
            );
        }
        $product = Product::create($data);

        //save product images
        if (isset($data['images'])) {
            $files = $data['images'];
            $uploadedFiles = multipleFileUpload(
                $files,
                $filePrefix,
                $width,
                $height,
                $quality
            );    
            $imageData = array_map(function ($filePath) use ($product) {
                return [
                    'url' => $filePath,
                    'product_id' => $product->id
                ];
            }, $uploadedFiles);
            if (!empty($imageData)) {
                ProductImage::insert($imageData);
            }
        }
        return ProductShowResource::make($product);
    }

    public function show(string $slug) : ProductShowResource
    {
        $product = Product::where('slug', $slug)
        ->with('stocks', 'images')
        ->first();

        if (!$product) {
            abort(404, 'Product not found');
        }
        if($product->key_features){
            $product->key_features = json_decode($product->key_features);
        }
        if($product->variationOptions){
            $variants = json_decode($product->variationOptions, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                abort(500, 'Invalid JSON in variationOptions: ' . json_last_error_msg());
            }
            $attributes = array_map(function($item) {
                if (!isset($item["option"], $item["tags"][0])) {
                    return null;
                }

                $item["option"] = Variation::select('name', 'id')->find($item["option"]);
                if (!$item["option"]) {
                    return null;
                }

                $item["selectVariant"] = $item['tags'][0];
                return $item;
            }, $variants ?? []);

            $attributes = array_filter($attributes);
            $product->attributes = $attributes;

            $product->showPrice = showPrices($product);
            $product->currency = getSetting('currency');
            $product->currencySymble = getSetting('currency_symbol');
        }
        


        return ProductShowResource::make($product);
    }

    
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $data = $request->all();

        $filePrefix = $product->slug;
        $width = 500;
        $height = 530;
        $quality = 50;

        // update cover image
        if($request->hasFile('cover_image')){
            if ($product->cover_image) {
                if (File::exists(storage_path($product->cover_image))) {
                    File::delete(storage_path($product->cover_image));
                }
            }
            $data['cover_image'] = uploadFile(
                
                $request->file('cover_image'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        }

        // update cover image
        if($request->hasFile('hover_image')){
            if ($product->hover_image) {
                if (File::exists(storage_path($product->hover_image))) {
                    File::delete(storage_path($product->hover_image));
                }
            }
            $data['hover_image'] = uploadFile(

                $request->file('hover_image'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        }

        $product->update($data);


        //save product images
        if (isset($data['newImages'])) {
            $files = $data['newImages'];
            $uploadedFiles = multipleFileUpload(
                $files,
                $filePrefix,
                $width,
                $height,
                $quality
            );    
            $imageData = array_map(function ($filePath) use ($product) {
                return [
                    'url' => $filePath,
                    'product_id' => $product->id
                ];
            }, $uploadedFiles);
            if (!empty($imageData)) {
                ProductImage::insert($imageData);
            }
        }

        return ProductShowResource::make($product);

    }

    public function deleteImage(string $id)
    {
        $image = ProductImage::findOrFail($id);
        if($image)
        {
            if (File::exists(public_path($image->url))) {
                File::delete(public_path($image->cover_image));
            }
            $image->delete();

            return Response::HTTP_OK;
        }
    }
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            if ($product->cover_image) {
                if (File::exists(public_path($product->cover_image))) {
                    File::delete(public_path($product->cover_image));
                }
            }
            if ($product->hover_image) {
                if (File::exists(public_path($product->hover_image))) {
                    File::delete(public_path($product->hover_image));
                }
            }
            if($product->images){
                foreach ($product->images as $image) {
                    if (File::exists(public_path($image->url))) {
                        File::delete(public_path($image->url));
                    }
                    $image->delete();
                }
            }
            $product->delete();
            return Response::HTTP_OK;
        }
    }
}