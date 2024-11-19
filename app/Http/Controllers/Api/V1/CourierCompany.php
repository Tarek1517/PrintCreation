<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CourierCompany as ModelsCourierCompany;
use Illuminate\Http\Request;
use function App\Http\Helpers\uploadFile;

class CourierCompany extends Controller
{
    public function index()
    {
        $companies = ModelsCourierCompany::query()->get();
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
			$company = ModelsCourierCompany::create($data);
			return response()->json($company);
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
