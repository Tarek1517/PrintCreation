<?php
namespace App\Http\Helpers;
use App\Models\Setting;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;    
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;



if (!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}

if(!function_exists('uploadFile')) {
    function uploadFile($file,  $fileNamePrefix, $resizeWidth = null, $resizeHeight = null, $quality = 50)
    {
        $uploadPath = 'images/uploads';
        $modifiedPath = 'app/public/uploads';
        $imageName = $fileNamePrefix . '-'. time() . '.webp';

        $destinationPath = public_path($uploadPath);
        
        $file->move($destinationPath, $imageName);

        $manager = new ImageManager(new Driver());

        $modImg = $manager->read(public_path($uploadPath . '/' . $imageName));

        $modImg->encode(new WebpEncoder(quality: $quality));

        if($resizeWidth !== null && $resizeHeight !== null){
            $modImg->resize($resizeWidth, $resizeHeight);
        }
        $modImg->save(storage_path($modifiedPath . '/' . $imageName));

        //deleting main file;
        File::delete(public_path($uploadPath . '/' . $imageName));

        return '/storage/uploads/' . $imageName;
    }
}

if(!function_exists('multipleFileUpload')){
    function multipleFileUpload($images, $fileNamePrefix = 'file', $resizeWidth = null, $resizeHeight = null, $quality = 50){
        $uploadPath = 'images/uploads';
        $modifiedPath = 'app/public/uploads';
        $uploadedData = array();

        foreach ($images as $image) {
            $imageName = $fileNamePrefix . time() . uniqid() . '.webp';
            $destinationPath = public_path($uploadPath);
            $image['file']->move($destinationPath, $imageName);
            $manager = new ImageManager(new Driver());
            $modImg = $manager->read(public_path($uploadPath . '/' . $imageName));
            $modImg->encode(new WebpEncoder(quality: $quality));
            if($resizeWidth !== null && $resizeHeight !== null){
                $modImg->resize($resizeWidth, $resizeHeight);
            }
            $modImg->save(storage_path($modifiedPath . '/' . $imageName));
            //deleting main file;
            File::delete(public_path($uploadPath . '/' . $imageName));
            $uploadedData[] = '/storage/uploads/' . $imageName;
        }
        return $uploadedData;
    }
}


if (! function_exists('showPrices')) {
    function showPrices($product)
    {
        $lowest_price = $product->buying_price;
        $highest_price = $product->buying_price;

        if (true) {
            foreach ($product->stocks as $key => $stock) {
                if($lowest_price > $stock->price){
                    $lowest_price = $stock->price;
                }
                if($highest_price < $stock->price){
                    $highest_price = $stock->price;
                }
            }
        }
        $lowest_price = floatval($lowest_price);
        $highest_price = floatval($highest_price);

        if($lowest_price == $highest_price){
            return formatPrice($lowest_price);
        }
        else{
            return formatPrice($lowest_price).' - '.formatPrice($highest_price);
        }
    }
}


if(! function_exists('formatPrice')){
    function formatPrice($price): string
    {
        return getSetting('pre', false) ? getSetting('currency_symbol').$price : $price.getSetting('currency_symbol');
    }
}