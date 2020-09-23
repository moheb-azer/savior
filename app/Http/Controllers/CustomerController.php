<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $customers = Customer::all();
        
        return compact('customers');
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
        if ($request->ajax()) {
            request()->validate([
                'c_name' => 'required',
                'c_phone1' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            ], [
                'c_name.required' => 'Customer\'s Name is required',

                'c_phone1.required' => 'Customer\'s Phone Number is required',
                'c_phone1.regex' => 'Customer\'s Phone Number should be digits only "0-9"',
                'c_phone1.min' => 'Customer\'s Phone Number must be at least :min.',
                'c_phone1.max' => 'Customer\'s Phone Number may not be greater than :max.',

            ]);
        }

        if ($request->c_phone2 != '') {
            request()->validate([
                'c_phone2' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11'
            ], [
                'c_phone2.regex' => 'Customer\'s Phone2 Number should be digits only "0-9"',
                'c_phone1.min' => 'Customer\'s 2nd Phone Number must be at least :min.',
                'c_phone1.max' => 'Customer\'s 2nd Phone Number may not be greater than :max.',
            ]);
        }

        $customer = Customer::create($request->all());
        return response()->json($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return void
     */
    public function show(Customer $customer)
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
        $customer = Customer::find($id);
        return response()->json($customer);
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
        if ($request->ajax()) {
            request()->validate([
                'c_name' => 'required',
                'c_phone1' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            ], [
                'c_name.required' => 'Customer\'s Name is required',

                'c_phone1.required' => 'Customer\'s Phone Number is required',
                'c_phone1.regex' => 'Customer\'s Phone Number should be digits only "0-9"',
                'c_phone1.min' => 'Customer\'s Phone Number must be at least :min.',
                'c_phone1.max' => 'Customer\'s Phone Number may not be greater than :max.',

            ]);
        }

        if ($request->c_phone2 != '') {
            request()->validate([
                'c_phone2' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11'
            ], [
                'c_phone2.regex' => 'Customer\'s Phone2 Number should be digits only "0-9"',
                'c_phone1.min' => 'Customer\'s 2nd Phone Number must be at least :min.',
                'c_phone1.max' => 'Customer\'s 2nd Phone Number may not be greater than :max.',
            ]);
        }

        $customer = Customer::find($id)->update($request->all());
        return response()->json($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $customer = Customer::find($id)->delete();

    }
}
