<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $expenses = DB::table('expenses')
            ->join('expense_items', 'expense_items.id', '=', 'expenses.item_id')
            ->select('expenses.*', 'expense_items.item_name')
			->where('expenses.deleted_at', '=', NULL)
			->get();
        return compact('expenses');
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
            ]);}
        $expense = Expense::create($request->all());
        return response()->json($expense);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Subcategory $subcategory
     * @return JsonResponse
     */
    public function show(Expense $expense)
    {
        $items = DB::table('expense_items')->get();
        return response()->json($items);

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
