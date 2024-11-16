<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductReviewRequest;
use App\Http\Resources\V1\Product\ReviewResource;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductReviewController extends Controller
{
    
    public function index()
    {
        return ReviewResource::collection(ProductReview::query()->with('product:id,cover_image,title')->latest()->get());
    }
    public function store(ProductReviewRequest $request)
    {
        return ReviewResource::make(ProductReview::query()->create($request->validated()));
    }

    public function update(Request $request, string $id)
    {
        
    }

 
    public function destroy(string $id)
    {
        $review = ProductReview::findOrFail($id);

        return Response::HTTP_OK;
    }
}
