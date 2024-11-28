<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\FooterRequest;
use App\Http\Resources\V1\FooterResource;
use App\Models\Footer;
use App\Models\Page;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = Footer::query()->orderBy('order_number')->get();

        foreach ($columns as $column) {
            $pageIds = json_decode($column->pages);
            $pages = Page::query()->whereIn('id', $pageIds)->get();

            $column['pages'] = $pages;
        }

        return FooterResource::make($columns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FooterRequest $request)
    {

        $data = $request->validated();
        $count = isset($data['pages']) ? count($data['pages']) : 0;
        $data['pages'] = json_encode($data['pages'] ?? []);
        $footer = Footer::create($data);
        return FooterResource::make($footer);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FooterRequest $request, string $id)
    {
        $data = $request->validated();
        $footer = Footer::find($id);
        $footer->update($data);

        return FooterResource::make($footer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $footer = Footer::find($id);
        if ($footer) {
            $footer->delete();

            return Response::HTTP_OK;
        }
    }
}
