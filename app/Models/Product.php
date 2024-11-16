<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function creator() :BelongsTo 
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy() :BelongsTo 
    {
        return $this->belongsTo(User::class, 'updatedd_by');
    }
    public function category() :BelongsTo
    {
        return  $this->belongsTo(Category::class);
    }

    public function brand() :BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images() :HasMany
    {
        return $this->hasMany(ProductImage::class);
    }


    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productVariationOptions()
    {
        return $this->belongsToMany(Product::class, 'product_variation_stock', 'product_id', 'variation_option_id')
            ->withPivot(['variant_id','variation_option_id', 'price', 'stock', 'sku']);
    }


    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function review()
    {
        return $this->hasMany(ProductReview::class);
    }
}