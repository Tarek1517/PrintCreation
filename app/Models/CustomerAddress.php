<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function area()
    {
        return $this->belongsTo(ShippingArea::class, 'shipping_area_id');
    }
}
