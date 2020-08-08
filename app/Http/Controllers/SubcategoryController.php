<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subcategories = DB::table('subcategories')
            ->join('categories', 'categories.id', '=', 'subcategories.cat_id')
            ->select('subcategories.id', 'subcategories.subcat_name','categories.cat_name')->get();
        echo '{"data":'.json_encode($subcategories).'}';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
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
                'subcat_name'=> 'required',
                'cat_id'=> 'required',
            ]);}
        $subcategory = Subcategory::create($request->all());
        return response()->json($subcategory);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Subcategory $subcategory
     * @return JsonResponse
     */
    public function show(Subcategory $subcategory)
    {
        $cats = Category::all();
        return response()->json($cats);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $subcategory = Subcategory::find($id);
        return response()->json($subcategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::find($id)->update($request->all());
        return response()->json($subcategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id)->delete();
        return response()->json(['done']);
    }
}
