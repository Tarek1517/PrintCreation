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
            ->with('children')
            ->orderBy('order_number')
            ->get();
        }

        $pageIds = json_decode(getSetting('header_pages'));
        $pages = [];
        if($pageIds !== null && count($pageIds) > 0){
            $pages = Page::whereIn('id', $pageIds??[])->select('slug', 'title')->get();
        }

        $allProducts = Product::query()->select('slug', 'title', 'cover_image')->get();


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
            'header_pages' => $pages,
            'all_products' => $allProducts,
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
            'delivery_charge_inside_dhaka' => getSetting('delivery_charge_inside_dhaka'),
            'delivery_charge_outside_dhaka' => getSetting('delivery_charge_outside_dhaka'), 
        ];
        return response()->json($settings);
    }
    public function getAllSetting()
    {
        $settings = [
            'header_categories' => json_decode(getSetting('header_categories')),
            'header_pages' => json_decode(getSetting('header_pages')),
            'discover_categories' => json_decode(getSetting('discover_categories')),
            'home_content' => getSetting('home_content'),
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
            'featured_categories' => json_decode(getSetting('featured_categories')),
            'online_exclusive_products' => json_decode(getSetting('online_exclusive_products')),
            'delivery_charge_inside_dhaka' => getSetting('delivery_charge_inside_dhaka'),
            'delivery_charge_outside_dhaka' => getSetting('delivery_charge_outside_dhaka'),
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