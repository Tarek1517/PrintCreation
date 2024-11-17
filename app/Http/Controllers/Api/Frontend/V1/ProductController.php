<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductReviewRequest;
use App\Http\Resources\V1\Category\CategoryShowResource;
use App\Http\Resources\V1\Product\ReviewResource;
use App\Http\Resources\V1\Product\ProductListResource;
use App\Http\Resources\V1\Product\ProductShowResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variation;
use App\Models\ProductReview;

use function App\Http\Helpers\showPrices;
use function App\Http\Helpers\getSetting;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
        ->with('category','brand')
        ->where('title', 'like', '%' . $request->input('search') . '%')
        ->when($request->input('category_id'), function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->when($request->input('brand_id'), function ($query, $categoryId) {
            return $query->where('brand_id', $categoryId);
        })
        ->latest()
        ->paginate(2);
        return ProductListResource::collection($products);
    }


    public function getSearchProduct(Request $request)
    {
        $products = Product::query()
        ->select('slug', 'title', 'cover_image', 'key_features','price')
        ->where('title', 'like', '%' . $request->input('query') . '%')
        ->take(20)
        ->get();

        foreach($products as $product){
            $product->key_features = json_decode($product->key_features);
        }
        return ProductListResource::collection($products);
    }
    

    public function getCategoryProduct($slug)
    {
        $category = Category::query()->where('slug', $slug)->with('products','products.category', 'children')->first();
        return CategoryShowResource::make($category);
    }

    
    public function show(string $slug)
    {
        $product = Product::query()
        ->where('slug', $slug)
        ->with('images', 'category',  'stocks', 'review')
        ->withCount('review')
        ->withSum('review', 'rating')
        ->first();


        $product->relatedProducts = Product::query()->where('category_id', $product->category->id)->whereNot('id', $product->id)->with('category')->get();
        
        if($product->key_features){
            $product->key_features = json_decode($product->key_features);
        }
        if ($product->variationOptions) {
            $variants = json_decode($product->variationOptions, true);
            $attributes = array_map(function ($item) {
                // Decode 'tags' into an array
                $item['tags'] = explode(',', $item['tags']);
                
                if (!isset($item["option"], $item["tags"][0])) {
                    return null;
                }
        
                $item["option"] = Variation::select('name', 'id', 'image')->find($item["option"]);
                if (!$item["option"]) {
                    return null;
                }
        
                $item["selectVariant"] = $item['tags'][0];
                return $item;
            }, $variants ?? []);
        
            $attributes = array_filter($attributes);
            $product->attributes = $attributes;
            $product->showPrice = showPrices($product);
        }

        $totalReviews = $product->review_count;
        $totalRatings = $product->review_sum_rating;
        $product->averageRating = $totalReviews > 0 ? $totalRatings / $totalReviews : 0;

        $product->currency = getSetting('currency');
        $product->currencySymble = getSetting('currency_symbol');

        return ProductShowResource::make($product);
    }

    public function saveProductReview(ProductReviewRequest $request)
    {
        return ReviewResource::make(ProductReview::query()->create($request->validated()));
    }
}