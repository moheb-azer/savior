<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @return array
     */
    public function store(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('p_name');
        $quantity = $request->input('qty');
        $price = $request->input('price');
        $salePrice = $request->input('salePrice');

        if(!empty($price) && !empty($salePrice)) {
            Cart::setGlobalTax(0);
            $add = Cart::add($id, $name, $quantity, $price,'0',['salePrice'=> $salePrice]);


            $details = array(
                'count'  => Cart::count(),
                'subTotal' => Cart::subtotal(),
                'total' => Cart::total(),
            );
        }

        return compact('details');

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
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

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function storeSale(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('p_name');
        $quantity = $request->input('qty');
        $price = $request->input('salePrice');

        Cart::setGlobalTax(0);
        $add = Cart::instance('sale')->add($id, $name, $quantity, $price );


        $details = array(
            'count'  => Cart::instance('sale')->count(),
            'subTotal' => Cart::instance('sale')->subtotal(),
            'total' => Cart::instance('sale')->total(),
        );


        return compact('details');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $rowId
     * @return array
     */
    public function deleteRowSale($rowId) {
        Cart::instance('sale')->remove($rowId);
        $details = array(
            'count'  => Cart::instance('sale')->count(),
            'subTotal' => Cart::instance('sale')->subtotal(),
            'total' => Cart::instance('sale')->total()
        );

        return compact('details');
    }

}



