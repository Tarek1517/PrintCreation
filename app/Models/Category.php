<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon', 
        'banner', 
        'description', 
        'status', 
        'short_description', 
        'order_number',
        'parent_id'
    ];

    protected $appends = ['icon_url'];
    public function getIconUrlAttribute()
    {
        return $this->icon ? env('APP_URL') . $this->icon : null;
    }

    public function products() : HasMany 
    {
        return $this->hasMany(Product::class);
    }
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->select(['id','parent_id','name','slug', 'icon', 'banner', 'description']);
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
