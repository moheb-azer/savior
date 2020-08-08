<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $suppliers = Supplier::all();
        echo '{"data":'.json_encode($suppliers).'}';
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
                's_name' => 'required',
                's_phone1' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            ], [
                's_name.required' => 'Supplier\'s Name is required',

                's_phone1.required' => 'Supplier\'s Phone Number is required',
                's_phone1.regex' => 'Supplier\'s Phone Number should be digits only "0-9"',
                's_phone1.min' => 'Supplier\'s Phone Number must be at least :min.',
                's_phone1.max' => 'Supplier\'s Phone Number may not be greater than :max.',

            ]);
        }

        if ($request->s_phone2 != '') {
            request()->validate([
                's_phone2' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11'
            ], [
                's_phone2.regex' => 'Supplier\'s Phone2 Number should be digits only "0-9"',
                's_phone1.min' => 'Supplier\'s 2nd Phone Number must be at least :min.',
                's_phone1.max' => 'Supplier\'s 2nd Phone Number may not be greater than :max.',
            ]);
        }

        $supplier = Supplier::create($request->all());
        return response()->json($supplier);
    }

    /**
     * Display the specified resource.
     *
     * @param Supplier $supplier
     * @return void
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Supplier $id
     * @return JsonResponse
     */
    public function edit( $id)
    {
        $supplier = Supplier::find($id);
        return response()->json($supplier);
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
                's_name' => 'required',
                's_phone1' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            ], [
                's_name.required' => 'Supplier\'s Name is required',

                's_phone1.required' => 'Supplier\'s Phone Number is required',
                's_phone1.regex' => 'Supplier\'s Phone Number should be digits only "0-9"',
                's_phone1.min' => 'Supplier\'s Phone Number must be at least :min.',
                's_phone1.max' => 'Supplier\'s Phone Number may not be greater than :max.',

            ]);
        }
        if ($request->s_phone2 != '') {
            request()->validate([
                's_phone2' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11'
            ], [
                's_phone2.regex' => 'Supplier\'s Phone2 Number should be digits only "0-9"',
                's_phone1.min' => 'Supplier\'s 2nd Phone Number must be at least :min.',
                's_phone1.max' => 'Supplier\'s 2nd Phone Number may not be greater than :max.',
            ]);
        }

        $supplier = Supplier::find($id)->update($request->all());
        return response()->json($supplier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Supplier $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id)->delete();
        return response()->json(['done']);
    }
}
