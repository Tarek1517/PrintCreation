<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierCompany extends Model
{
    use HasFactory;

	protected $guarded = ['id'];

		protected $appends = ['logo'];
		public function getLogoAttribute()
		{
			return $this->company_logo ? env('APP_URL') . $this->company_logo : null;
		}
}
