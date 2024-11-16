<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SliderRequest;
use App\Http\Resources\V1\SliderResource;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use function App\Http\Helpers\uploadFile;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::query()
        ->orderBy('order_number')
        ->paginate();
        return SliderResource::collection($sliders);
    }

    public function show($id)
    {
        $slider = Slider::find($id);

        return SliderResource::make($slider);
    }
    public function store(SliderRequest $request)
    {
        $data = $request->validated();
        $filePrefix = 'slider';
        $width = 1320;
        $height = 400;
        $quality = 50;

        // save cover image
        if($request->hasFile('image')){
            $data['image'] = uploadFile(
                $request->file('image'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        }

        $slider = Slider::create($data);
        return SliderResource::make($slider);
    }

    
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);
        
        $data = $request->validate([
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'url' => 'required|string',
            'order_number' => 'required|integer',
        ]);

        $filePrefix = 'slider';
        $width = 1320;
        $height = 400;
        $quality = 50;

        // save cover image
        if($request->hasFile('image')){
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }
            $data['image'] = uploadFile(
                $request->file('image'),
                $filePrefix,
                $width,
                $height,
                $quality
            );
        }else{
            $data['image'] = $slider->image;
        }

        $slider->update($data);

        return SliderResource::make($slider);
    }
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        if($slider){
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }
            $slider->delete();
            return Response::HTTP_OK;
        }
    }
}
