<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$collections = Collection::join('customers', 'collections.customer_id', '=', 'customers.id')
									->select('collections.*','customers.c_name', 'customers.credit')
									->get();
		
		return compact('collections');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if(empty($request->c_id)) {
     		request()->validate([
				'c_id' => 'required'
			],
			[
				'c_id.required' => 'Choose Customer From List'
			]);
		}
		
		$collection = Collection::create([
			'customer_id' => $request->c_id,
			'cash' => $request->collect,
			'balance' => $request->balance
		]);
		
		
		$customer = DB::table('customers')->where('id', '=', $request->c_id)->get();
		$newBalance =  $customer{0}->credit - $request->collect;
		DB::table('customers')
			->where('id', '=', $request->c_id)
			->update(['credit' => $newBalance]);
		
		return response()->json($collection);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$collection = Collection::join('customers', 'collections.customer_id', '=', 'customers.id')
					  		->select('collections.*', 'customers.c_name', 'customers.credit')
					  		->find($id);
		return $collection;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
