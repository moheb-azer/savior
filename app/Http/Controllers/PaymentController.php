<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$payments = Payment::join('suppliers', 'payments.supplier_id', '=', 'suppliers.id')
									->select('payments.*','suppliers.s_name', 'suppliers.credit')
									->get();
		
		return compact('payments');
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
		if(empty($request->s_id)) {
     		request()->validate([
				's_id' => 'required'
			],
			[
				's_id.required' => 'Choose Supplier From List'
			]);
		}
		
		$payment = Payment::create([
			'supplier_id' => $request->s_id,
			'cash' => $request->pay,
			'balance' => $request->balance
		]);
		
		
		$supplier = DB::table('suppliers')->where('id', '=', $request->s_id)->get();
		$newBalance =  $supplier{0}->credit - $request->pay;
		DB::table('suppliers')
			->where('id', '=', $request->s_id)
			->update(['credit' => $newBalance]);
		
		return response()->json($payment);
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
		$payment = Payment::join('suppliers', 'payments.supplier_id', '=', 'suppliers.id')
					  		->select('payments.*', 'suppliers.s_name', 'suppliers.credit')
					  		->find($id);
		return $payment;
    }

    /**
     * Update the specified ressource in storage.
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
