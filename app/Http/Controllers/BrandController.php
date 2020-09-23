<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $brands = Brand::all();
        return compact('brands');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->ajax()){
            $request->validate([
                'brand_name'=> 'required',

            ]);}
        $brand = Brand::create($request->all());
        return response()->json($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Brand $brand
     * @return void
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request,$id)
    {
        $brand = Brand::find($id)->update($request->all());
        return response()->json($brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $brand = Brand::find($id)->delete();
        return response()->json(['done']);
    }
}
