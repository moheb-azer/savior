<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerAccount;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $customers = DB::table('customers')

            ->select('customers.id','customers.c_name', 'customers.c_phone1','customers.c_phone2','customers.credit')
            ->get();



        return compact('customers');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerAccount  $customerAccount
     * @return Application|Factory|View
     */
    public function show($id)
    {

        $accounts = CustomerAccount::where('c_id', '=', $id)->get();
        $customer = Customer::find($id);
        return view('reports.customer_acc_details', compact('accounts','customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerAccount  $customerAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerAccount $customerAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerAccount  $customerAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerAccount $customerAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerAccount  $customerAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerAccount $customerAccount)
    {
        //
    }
}
