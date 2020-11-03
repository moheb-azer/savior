<?php

namespace App\Http\Controllers;

use App\ExpenseItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpenseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = ExpenseItem::all();
        return compact('items');
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
                'item_name'=> 'required',

            ]);}
        $item = ExpenseItem::create($request->all());
        return response()->json($item);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ExpenseItem $item
     * @return void
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ExpenseItem $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $item = ExpenseItem::find($id);
        return response()->json($item);
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
        $item = ExpenseItem::find($id)->update($request->all());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ExpenseItem $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $item = ExpenseItem::find($id)->delete();
        return response()->json(['done']);
    }
}
