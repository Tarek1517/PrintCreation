<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourierCompany;
use function App\Http\Helpers\uploadFile;

class CourierCompanyController extends Controller
{
    public function index()
    {
        $companies = CourierCompany::query()->get();
		return response()->json($companies);
    }

    public function store(Request $request)
    {
			$data = $request->validate([
				'company_name' => 'required',
				'company_logo' => 'nullable|image|max:1024',
				'delivery_charge' => 'required|integer'
			]);
			if($request->file('company_logo')){
				 $data['company_logo'] = uploadFile(
					$request->file('company_logo'),
					'courier_logo',
					100,
					100,
					50
				);
			}
			$company = CourierCompany::create($data);
			return response()->json($company);
    }

    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
