<?php

namespace App\Http\Controllers;

use App\Product;
use App\PurchasedProducts;
use App\Inventory;
use App\PurchaseInvoice;
use App\Supplier;
use App\SupplierAccount;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool
     */
    public function index()
    {
        //
        return true ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $cart = Cart::content();

        $purchaseInvoice = new PurchaseInvoice();
        $purchaseInvoice->supplier_id = $request->input('id');
        $purchaseInvoice->date = $request->input('date');
//        $purchaseInvoice->total = Cart::total();
        $purchaseInvoice->total =$request->input('cash') + $request->input('credit') ;
        $purchaseInvoice->cash = $request->input('cash');
        $purchaseInvoice->credit = $request->input('credit');
        $purchaseInvoice->save();



        $invoiceId = $purchaseInvoice->id;

        $supplierAcc = new SupplierAccount();
        $supplierAcc->s_id = $request->input('id');
        $supplierAcc->trans_type = "purchase_invoice";
        $supplierAcc->trans_id = $purchaseInvoice->id;
        $supplierAcc->date = $request->input('date');
        $supplierAcc->total = $request->input('cash') + $request->input('credit');
        $supplierAcc->cash = $request->input('cash');
        $supplierAcc->credit = $request->input('credit');
        $supplierAcc->save();



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
            $transaction->salePrice = $item->options->salePrice;
            $transaction->save();



            $product = Product::find($productId);
            $product->salePrice = $item->options->salePrice;
            $product->balance_units = $totalQty;
            $product->save();
        }

        Cart::destroy();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param PurchaseInvoice $purchaseInvoice
     * @return void
     */
    public function show(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PurchaseInvoice $purchaseInvoice
     * @return void
     */
    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PurchaseInvoice $purchaseInvoice
     * @return void
     */
    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PurchaseInvoice $purchaseInvoice
     * @return void
     */
    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
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
                'salePrice' => $item->options->salePrice,

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
            return "";
        } else{
            $suppliers = Supplier::where('s_name','like','%' . $searchValue['searchValue'] . '%')
                ->orWhere('s_phone1','like','%' . $searchValue['searchValue'] . '%')
                ->orWhere('s_phone2','like','%' . $searchValue['searchValue'] . '%')
                ->get();

            return $suppliers;
        }
    }
}
