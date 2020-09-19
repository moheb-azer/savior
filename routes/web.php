<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**/

/* Auth routes */
Auth::routes();


Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        return view('home');
    })->middleware('auth');

    Route::get('/customer', function () {
        return view('data.customers');
    })->name('customers_page');

    Route::get('/supplier', function () {
        return view('data.suppliers');
    })->name('suppliers_page');

    Route::get('/product', function () {
        return view('data.products');
    })->name('products_page');

    Route::get('/category', function () {
        return view('data.basic.categories');
    })->name('categories_page');

    Route::get('/subcategory', function () {
        return view('data.basic.subcategories');
    })->name('subcategories_page');

    Route::get('/brand', function () {
        return view('data.basic.brands');
    })->name('brands_page');

    /* start transactions */

    Route::get('/purchase_invoices', function () {
        return view('transactions.purchase_invoice');
    })->name('purchase_invoice_page');

    Route::get('/sale_invoice', function () {
        return view('transactions.sale_invoice');
    })->name('sale_invioces_page');


    /* end transactions*/
    Route::get('/customers_accounts', function () {
        return view('reports.customer_acc');
    })->name('customer_acc_page');




    /* start reports */

    /* end reports */

    /* start ajax crud routes */

    Route::resource('/customers', 'CustomerController');

    Route::resource('/suppliers', 'SupplierController');

    Route::resource('/categories', 'CategoryController');

    Route::resource('/subcategories', 'SubcategoryController');

    Route::resource('/brands', 'BrandController');

    Route::resource('/products', 'ProductController');





    Route::get('/cat/show', 'SubcategoryController@show')->name('show_cat');
    Route::get('/subcat/show', 'ProductController@subcategory')->name('show_subcat');
    Route::get('/brand/show', 'ProductController@brand')->name('show_brand');
//    Route::get('/invoice/show_customer', 'InvoiceController@showCustomer')->name('show_customer');
//    Route::get('/invoice/show_supplier', 'InvoiceController@showSupplier')->name('show_supplier');
//    Route::get('/invoice/show_product', 'InvoiceController@showProduct')->name('show_product');

    /*end ajax crud routes */



    /* purchase invoice */
    Route::resource('/cart','CartController');
    Route::get('/cart/{cart}',"CartController@deleteRow")->name('cart.deleterow');
    Route::get('/purchase_invoice/data_tables','PurchaseInvoiceController@datatables')->name('purchase_invoice.datatables');
    Route::get('/purchase_invoice/search','PurchaseInvoiceController@searchForSupplier')->name('purchase_invoice.searchforsupplier');
    Route::resource('/purchase_invoice','PurchaseInvoiceController');

    /* purchase invoice */

    /* sale invoice */
    Route::get('/sale_invoice/data_tables','SaleInvoiceController@datatables')->name('sale_invoice.datatables');
    Route::post('/cart_sale','CartController@storeSale')->name('cart_sale.store');
    Route::get('/cart_sale/delete/{rowId}','CartController@deleteRowSale')->name('cart_sale.delete');
    Route::get('/sale_invoice/search','SaleInvoiceController@searchForCustomer')->name('sale_invoice.searchforCustomer');
    Route::resource('/sale_invoices','SaleInvoiceController');


    /* sale invoice */

    /* reports */
    Route::resource('/customer_accounts', 'CustomerAccountController');


});


/*end database routes */





