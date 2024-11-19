<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

	protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        return $this->image ? env('APP_URL') . $this->image : null;
    }
}