<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('p_name');
        $quantity = $request->input('qty');
        $price = $request->input('price');

        Cart::setGlobalTax(0);
        $add = Cart::add($id, $name, $quantity, $price);

        $details = array(
            'count'  => Cart::count(),
            'subTotal' => Cart::subtotal(),
            'total' => Cart::total(),
        );


        return compact('details');

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
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
    public function deleteRow($rowId) {
        Cart::remove($rowId);
        $details = array(
            'count'  => Cart::count(),
            'subTotal' => Cart::subtotal(),
            'total' => Cart::total()
        );

        return compact('details');
    }

    public function destroy($id)
    {
        //
    }
}
