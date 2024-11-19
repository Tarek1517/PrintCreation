<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function checkout()
	{
		Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
		$session = \Stripe\Checkout\Session::create([
			'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => 500,
                        'product_data' => ['name' => 'Cool Stripe Checkout.']
                    ],
                    'quantity' => 1
                ]
            ],
			'mode' => 'payment',
			'success_url' => env('FRONTEND_URL') . '?success=true',
			'cancel_url' => env('FRONTEND_URL') . '?canceled=true',
		]);
		 return response()->json([
			'id' => $session->id, 
			'url' => $session->url, 
		]);
	}
}
