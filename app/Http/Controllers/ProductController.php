<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use App\Subcategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $products = DB::table('products')
            ->join('subcategories', 'subcategories.id', '=', 'products.subcat_id')
            ->join('categories', 'categories.id', '=', 'subcategories.cat_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select('products.id', 'products.p_code','products.p_name', 'products.description',
            'subcategories.subcat_name', 'categories.cat_name', 'brands.brand_name')
            ->get();
        echo '{"data":'.json_encode($products).'}';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
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
            request()->validate([
                'p_code'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'p_name'=> 'required',
                'cat_id'=> 'required',
            ],[
                'p_code.required'=>'Code is required',
                'p_code.regex'=>'Code should be Digits only "0-9" ',
                'p_name.required'=>'Product\'s Name is required',
                'cat_id.required' => 'Category & Subcategory are required ',
            ]);}
        $product = Product::create($request->all());
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return void
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
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
        if ($request->ajax()){
            request()->validate([
                'p_code'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'p_name'=> 'required',
                'cat_id'=> 'required',
            ],[
                'p_code.required'=>'Code is required (Digits only "0-9")',
                'p_code.regex'=>'Code should be Digits only "0-9" ',

                'p_name.required'=>'Product\'s Name is required',
                'cat_id.required' => 'Category & Subcategory are required ',
            ]);}

        $product = Product::find($id)->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id)->delete();
        return response()->json(['done']);
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function cat()
    {
        $cats = Category::all();
        return response()->json($cats);
    }
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function subcategory()
    {
        $subcat = Subcategory::all();
        return response()->json($subcat);
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function brand()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }


}
