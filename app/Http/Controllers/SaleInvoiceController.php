<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerAccount;
use App\Inventory;
use App\SaledProducts;
use App\SaleInvoice;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleInvoiceController extends Controller
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
     * @param $request
     * @return void
     */
    public function create(Request $request)
    {
        echo $request;
        $cart = Cart::instance('sale')->content();

//        insert new record to sale_invoice table
        $saleInvoice = new SaleInvoice();
        $saleInvoice->customer_id = $request->input('id');
        $saleInvoice->date = $request->input('date');
        // $saleInvoice->total = Cart::total();
        $saleInvoice->total =$request->input('cash') + $request->input('credit') ;
        $saleInvoice->cash = $request->input('cash');
        $saleInvoice->credit = $request->input('credit');
        $saleInvoice->save();

        $invoiceId = $saleInvoice->id;


//        insert new record to customer_accouts table
        $customerAcc = new CustomerAccount();
        $customerAcc->c_id = $request->input('id');
        $customerAcc->trans_type = "sale_invoice";
        $customerAcc->trans_id = $invoiceId;
        $customerAcc->date = $request->input('date');
        $customerAcc->total = $request->input('cash') + $request->input('credit');
        $customerAcc->cash = $request->input('cash');
        $lastcredit = CustomerAccount::where('c_id', '=', $request->input('id'))
            ->latest('id')
            ->limit(1)
            ->get();
        if ($lastcredit == '[]'){
        $customerAcc->credit = $request->input('credit');
        } else{
            $newCredit = $lastcredit[0]['credit'] + $customerAcc->total - $customerAcc->cash;
            $customerAcc->credit = $newCredit;
        }
        $customerAcc->save();

//        update credit in customer table
        $updateBalance = Customer::find($request->input('id'));
        $updateBalance->credit = $newCredit;
        $updateBalance->save();



        foreach ($cart as $item){
            $productId = $item->id;
            $quantity = $item->qty;
            $unit_price = $item->price;
            $totalPrice = $item->subtotal;

            $saledProduct = new SaledProducts();
            $saledProduct->invoice_id = $invoiceId;
            $saledProduct->p_id = $productId;
            $saledProduct->units = $quantity;
            $saledProduct->unit_salePrice = $unit_price;
            $saledProduct->total_salePrice = $totalPrice;
            $saledProduct->save();

            $lastTransaction = Inventory::where('p_id', '=', $productId)
                ->latest('id')
                ->limit(1)
                ->get();

            if($lastTransaction == '[]') {

                // error alert
            } else{


                $lastBalance=$lastTransaction[0]["balance_cost"];
                $stockQuantity=$lastTransaction[0]["balance_units"];
                $lastAverageCost = $lastTransaction[0]["average_cost"];
//                foreach($lastTransaction as $arr) {
//                    $lastBalance = $arr['balance_cost'];
//                    $stockQuantity = $arr['balance_units'];
//                    $lastAverageCost =  $arr['average_cost'];
//                }
//                $lastBalance = $lastTransaction['balance_cost'];
//                $stockQuantity = $lastTransaction['balance_units'];
                $totalCost = $quantity * $lastAverageCost;

                $balance = $lastBalance - $totalCost;
                $totalQty = $stockQuantity - $quantity;
//                $averageCost = $balance / $totalQty;
            }
            $transaction = new Inventory();
            $transaction->p_id =  $productId;
            $transaction->invoice_type = 'sale';
            $transaction->date = $request->input('date');
            $transaction->units = $quantity;
            $transaction->unit_cost = $lastAverageCost;
            $transaction->total_cost = $totalCost;
            $transaction->balance_units = $totalQty;
            $transaction->average_cost = $lastAverageCost;
            $transaction->balance_cost = $balance;
            $transaction->salePrice = $item->price;

            $transaction->save();


        }
        Cart::instance('sale')->destroy();
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
     * @param  \App\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(SaleInvoice $saleInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleInvoice $saleInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleInvoice $saleInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SaleInvoice  $saleInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleInvoice $saleInvoice)
    {
        //
    }


    public function dataTables(){

        $products = DB::table('products')
            ->join('subcategories', 'subcategories.id', '=', 'products.subcat_id')
            ->join('categories', 'categories.id', '=', 'subcategories.cat_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
//            ->join('inventories','inventories.p_id', '=', 'products.id')->latest('inventories.created_at')->limit(1)
            
            ->select('products.id', 'products.p_code', 'products.p_name', 'products.description',
                 'subcategories.subcat_name', 'categories.cat_name', 'brands.brand_name',
                'inventories.salePrice', 'inventories.balance_units')
            ->get();

//        dd($products);
        $cart = Cart::instance('sale')->content();
        $items = array();

        foreach ($cart as $item) {
            $items[] = array(

                'id' => $item->id,
                'name' => $item->name,
                'qty' => $item->qty,
                'salePrice' => $item->price,
                'rowId' => $item->rowId,
                'subtotal' => $item->subtotal
            );
        }

        return compact('products', 'items');
    }

    public function searchForCustomer(Request $searchValue)
    {
        if($searchValue['searchValue'] == "") {
            return "";
        } else{
            $customers = Customer::where('c_name','like','%' . $searchValue['searchValue'] . '%')
                ->orWhere('c_phone1','like','%' . $searchValue['searchValue'] . '%')
                ->orWhere('c_phone2','like','%' . $searchValue['searchValue'] . '%')
                ->get();

            return $customers;
        }

    }



}
