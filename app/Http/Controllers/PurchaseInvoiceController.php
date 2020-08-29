<?php

namespace App\Http\Controllers;

use App\Product;
use App\PurchasedProducts;
use App\Inventory;
use App\PurchaseInvoice;
use App\Supplier;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;


class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return true ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = Cart::content();

        $purchaseInvoice = new PurchaseInvoice();
        $purchaseInvoice->supplier_id = $request->input('id');
        $purchaseInvoice->date = $request->input('date');
        $purchaseInvoice->total = Cart::total();
        $purchaseInvoice->cash = $request->input('cash');
        $purchaseInvoice->credit = $request->input('credit');

        $purchaseInvoice->save();

        $invoiceId = $purchaseInvoice->id;
        foreach ($cart as $item) {
            $productId = $item->id;
            $quantity = $item->qty;
            $cost = $item->price;
            $totalCost = $item->subtotal;

            $purchasedProduct = new PurchasedProducts();
            $purchasedProduct->invoice_id = $invoiceId;
            $purchasedProduct->p_id = $productId;
            $purchasedProduct->units = $quantity;
            $purchasedProduct->unit_cost = $cost;
            $purchasedProduct->total_cost = $totalCost;
            $purchasedProduct->save();

            $lastTransaction = Inventory::where('p_id', '=', $productId)
                ->latest('id')
                ->limit(1)
                ->get();

            if($lastTransaction == '[]') {

                $totalQty = $quantity;
                $averageCost = $cost;
                $balance = $totalCost;

            } else{

                foreach($lastTransaction as $arr) {
                    $lastBalance = $arr['balance_cost'];
                    $stockQuantity = $arr['balance_units'];
                }
//                $lastBalance = $lastTransaction['balance_cost'];
//                $stockQuantity = $lastTransaction['balance_units'];

                $balance = $lastBalance + $totalCost;
                $totalQty = $stockQuantity + $quantity;
                $averageCost = $balance / $totalQty;
            }

            $transaction = new Inventory();
            $transaction->p_id =  $productId;
            $transaction->invoice_type = 'purchase';
            $transaction->date = $request->input('date');
            $transaction->units = $quantity;
            $transaction->unit_cost = $cost;
            $transaction->total_cost = $totalCost;
            $transaction->balance_units = $totalQty;
            $transaction->average_cost = $averageCost;
            $transaction->balance_cost = $balance;
            $transaction->save();

        }

        Cart::destroy();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        //
    }


    public function dataTables() {

        $products = DB::table('products')
            ->join('subcategories', 'subcategories.id', '=', 'products.subcat_id')
            ->join('categories', 'categories.id', '=', 'subcategories.cat_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select('products.id', 'products.p_code','products.p_name', 'products.description',
                'subcategories.subcat_name', 'categories.cat_name', 'brands.brand_name')
            ->get();
        $cart = Cart::content();
        $items = array();

        foreach($cart as $item) {
            $items[] = array (
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'qty' => $item->qty,
                'rowId' => $item->rowId,
                'subtotal' => $item->subtotal
            );
        }

        return compact('products', 'items');

    }


    public function searchForSupplier(Request $searchValue)
    {
        if($searchValue['searchValue'] == "") {
            $empty = "";
            return $empty;
        } else{
            $suppliers = Supplier::where('s_name','like','%' . $searchValue['searchValue'] . '%')
                ->orWhere('s_phone1','like','%' . $searchValue['searchValue'] . '%')
                ->orWhere('s_phone2','like','%' . $searchValue['searchValue'] . '%')
                ->get();

            return $suppliers;
        }
    }
}
