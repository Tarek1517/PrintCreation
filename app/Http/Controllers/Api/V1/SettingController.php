<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Footer;
use App\Models\Slider;

use function App\Http\Helpers\getSetting;

class SettingController extends Controller
{
    public function getGlobalSetting()
    {
        $categoryIds = json_decode(getSetting('header_categories'));
        $categories = [];
        if($categoryIds !== null && count($categoryIds) > 0){
            $categories = Category::whereIn('id', $categoryIds??[])
            ->select('id','slug', 'icon', 'name', 'parent_id')
            ->with('children:id,name,slug')
            ->orderBy('order_number')
            ->get();
        }


		$topCategoryIds = json_decode(getSetting('top_categories'));
        $topCategories = [];
        if($topCategoryIds !== null && count($topCategoryIds) > 0){
            $topCategories = Category::whereIn('id', $topCategoryIds??[])
            ->select('id','slug', 'icon', 'name')
			->withCount('products')
            ->orderBy('order_number')
            ->get();
        }

		$homeProductIds = json_decode(getSetting('home_products'));
		$homeProducts = [];
		if($homeProductIds !== null && count($homeProductIds) > 0){
            $homeProducts = Product::whereIn('id', $homeProductIds??[])
            ->select('slug', 'title', 'cover_image', 'price', 'discount_price')
            ->get();
        }

        $footerColumns = Footer::query()->orderBy('order_number')->get();
        foreach( $footerColumns as $column){
            $footerPageIds = json_decode($column->pages);
            $footerPages = Page::query()->whereIn('id', $footerPageIds)->select('slug', 'title')->get();
            $column['pages'] = $footerPages;
        }

        $settings = [
            'currency' =>  getSetting('currency'),
            'currency_symbol' => getSetting('currency_symbol'),
            'header_categories' => $categories,
			'hero_slider' => Slider::select('url','image','order_number')->orderBy('order_number')->get(),
			'home_products' => $homeProducts,
			'top_categories' => $topCategories,
            'all_products' =>Product::query()->select('slug', 'title', 'cover_image', 'price', 'discount_price')->latest()->paginate(16),
            'all_categories' => Category::query()->select('slug', 'name', 'id')->get(),
            'footer_columns' => $footerColumns,
            'app_name' => getSetting('app_name'),
            'email' => getSetting('email'),
            'phone_number' => getSetting('phone_number'),
            'whatsapp_number' => getSetting('whatsapp_number'),
            'hotline_number' => getSetting('hotline_number'),
            'facebook_link' => getSetting('facebook_link'),
            'youtube_link' => getSetting('youtube_link'),
            'instagram_link' => getSetting('instagram_link'),
            'linkedin_link' => getSetting('linkedin_link'),
        ];
        return response()->json($settings);
    }
    public function getAllSetting()
    {
        $settings = [
            'header_categories' => json_decode(getSetting('header_categories')),
            'top_categories' => json_decode(getSetting('top_categories')),
            'home_products' => json_decode(getSetting('home_products')),
            'currency' => getSetting('currency'),
            'currency_symbol' => getSetting('currency_symbol'),
            'app_name' => getSetting('app_name'),
            'email' => getSetting('email'),
            'app_url' => env('APP_URL'),
            'phone_number' => getSetting('phone_number'),
            'whatsapp_number' => getSetting('whatsapp_number'),
            'hotline_number' => getSetting('hotline_number'),
            'facebook_link' => getSetting('facebook_link'),
            'youtube_link' => getSetting('youtube_link'),
            'instagram_link' => getSetting('instagram_link'),
            'linkedin_link' => getSetting('linkedin_link'),
        ];

        return response()->json($settings);
    }
    public function saveHeaderSetting(Request $request)
    {
        $data =  $request->all();

        foreach($data as $type => $value){
            $settings = Setting::where('key', $type)->first();

            if($settings != null) {
                if($value != null) {
                    if(gettype($value) == 'array'){
                        $settings->value = json_encode($value);
                    }
                    else {
                        $settings->value = $value;
                    }
                    $settings->save();
                }
            }else {
                if ($value != null){
                    $settings = new Setting;
                    $settings->key = $type;
                    if(gettype($value) == 'array'){
                        $settings->value = json_encode($value);
                    }
                    else {
                        $settings->value = $value;
                    }
                    $settings->save();
                }
            }
        }

        return Response::HTTP_OK;
    }

    public function saveLogo(Request $request)
    {
        $request->validate([
            'header_logo' => 'nullable|image',
            'footer_logo' => 'nullable|image',
            'fav_icon' => 'nullable|image',
        ]);

        if ($request->hasFile('header_logo')){
            $settings = Setting::where('type', 'header_logo')->first();
            if ($settings?->value != null){
                Storage::disk('public')->delete($settings->value);
            }
            $value = $request->file('header_logo')->store('uploads', 'public');
            $settings->value = '/storage/' . $value;
            $settings->save();
        }
        if ($request->hasFile('footer_logo')){
            $settings = Setting::where('type', 'footer_logo')->first();
            if ($settings?->value != null){
                Storage::disk('public')->delete($settings->value);
            }
            $value = $request->file('footer_logo')->store('uploads', 'public');
            $settings->value ='/storage/' . $value;
            $settings->save();
        }

        if ($request->hasFile('fav_icon')){
            $settings = Setting::where('type', 'fav_icon')->first();
            if ($settings?->value != null){
                Storage::disk('public')->delete($settings->value);
            }
            $value = $request->file('fav_icon')->store('uploads', 'public');
            $settings->value ='/storage/' . $value;
            $settings->save();
        }
    }
}