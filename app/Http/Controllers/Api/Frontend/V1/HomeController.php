<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PageRequest;
use App\Http\Resources\V1\PageResource;
use App\Http\Resources\V1\SliderResource;
use App\Http\Resources\V1\Category\CategoryListResource;
use App\Http\Resources\V1\HomeSectionResource;
use App\Http\Resources\V1\FooterResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Page;
use App\Models\Footer;
use App\Models\Variation;


use function App\Http\Helpers\showPrices;
use function App\Http\Helpers\getSetting;

class HomeController extends Controller
{
    


    public function getHeroSlider()
    {
        $sliders = Slider::query()
        ->orderBy('order_number')
        ->get();

        return SliderResource::collection($sliders);
    }

    public function getHomeSection()
    {
        $homeSection = HomeSection::query()->get();

        foreach($homeSection as $section){

            if($section->categories){
                $categoryIds = json_decode($section->categories);
                $section['categories'] = Category::query()->whereIn('id', $categoryIds)->select('slug', 'name', 'icon')->get();
            }

            if($section->products){
                $productIds = json_decode($section->products);
                $products = Product::query()
                ->whereIn('id', $productIds)
                ->select('slug', 'title', 'cover_image', 'hover_image', 'key_features', 'price', 'discount_price', 'category_id')
                ->with( 'category')
                ->get();

                foreach($products as $product){
                    $product->key_features = json_decode($product->key_features);   
                }
                $section['products'] = $products;
            }
        }
        
        return HomeSectionResource::collection($homeSection);
    }

    public function getHomeContent()
    {
        $categoryIds = json_decode(getSetting('discover_categories'));
        $categories = [];
        if($categoryIds !== null && count($categoryIds) > 0){
            $categories = Category::whereIn('id', $categoryIds??[])->select('name', 'slug', 'icon')->get();
        }

        //home page featured categories
        $fCategoryIds = json_decode(getSetting('featured_categories'));
        if($fCategoryIds !== null && count($fCategoryIds) > 0){
            $fcategories = Category::whereIn('id', $fCategoryIds??[])->select('name', 'slug', 'icon')->get();
        }

        // home page online exclusive products
        $products = array();
        $productIds = json_decode(getSetting('online_exclusive_products'));
        if($productIds !== null && count(value: $productIds) > 0){
            $products = Product::whereIn('id', $productIds??[])->select('title', 'cover_image', 'hover_image','slug', 'price','discount_price', 'category_id')->with('category')->get();
        }

        $settings = [
            'discover_categories' => $categories,
            'home_content' => getSetting('home_content'),
            'featured_categories' => $fcategories,
            'online_exclusive_products' => $products,
        ];

        return response()->json($settings);

    }

    public function getCustomPage($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return PageResource::make($page);
    }

}