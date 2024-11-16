<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductVariationStorRequest;
use App\Http\Resources\V1\Product\ProductVariationResource;
use App\Http\Resources\V1\Product\VariationResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;


use App\Models\Product;
use App\Models\Variation;
use App\Models\ProductStock;

class ProductVariationController extends Controller
{
    public function index()
    {
        $variations = Variation::query()->with('variationOptions')->select('id', 'slug', 'name')->get();

        return VariationResource::collection($variations);
    }


    public function store(Request $request)
    {
        $request->validate([
            'variationDivider' => 'required|string',
            'varientSkuPrefix' => 'required|string',
            'defaultQty' => 'required|integer',
            'product_variant' => 'required|array',
            'product_variant_prices' => 'required|array',
            'productSlug' => 'required|string',
        ]);

        // Get the product by slug
        $product = Product::where('slug', $request->input('productSlug'))->firstOrFail();

        // Update product variations and variation options
        $variationIds = collect($request->product_variant)->map(fn($item) => $item['option']);
        $product->variations = json_encode($variationIds);
        $product->variationOptions = json_encode($request->product_variant);
        $product->save();

        // Handle the product variations
        $variationsArray = collect($request->product_variant_prices)->map(function($item) use ($product) {
            return [
                'product_id' => $product->id,
                'varient' => $item['title'],
                'sku' => $item['sku'].rand(111111, 999999),
                'price' => $item['price'],
                'stock' => $item['stock'],
                'bar_code' => rand(111111, 999999),
            ];
        });

        // Update or create variations
        foreach ($variationsArray as $variation) {
            ProductStock::updateOrCreate(
                ['product_id' => $variation['product_id'], 'varient' => $variation['varient']],
                $variation
            );
        }

        return response()->json(['message' => 'Variations updated successfully'], Response::HTTP_OK);
    }



    public function show(string $slug)
    {
        $product = Product::query()
        ->where('slug', $slug)
        ->select('id','title', 'cover_image', 'price', 'discount_price')
        ->with('stocks', 'stocks.product')
        ->first();

        return VariationResource::make($product);
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        $variation = ProductStock::find($id);

        if($variation){
            $image = $variation->image;
            if($image){
                $imagePath = str_replace('/storage','public',$image);
                Storage::delete($imagePath);
            }
            $variation->delete();
            return Response::HTTP_OK;
        }
    }
}