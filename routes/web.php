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

    Route::get('/purcahse_invoice', function () {
        return view('transactions.purchase_invoice');
    })->name('purchase_invioces_page');

    /* end transactions*/

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




    Route::resource('/cart','CartController');
    Route::get('/cart/{cart}',"CartController@deleteRow")->name('cart.deleterow');
    Route::get('/purchase_invoice/data_tables','PurchaseInvoiceController@datatables')->name('purchase_invoice.datatables');
    Route::get('/purchase_invoice/search','PurchaseInvoiceController@searchForSupplier')->name('purchase_invoice.searchforsupplier');
    Route::resource('/purchase_invoice','PurchaseInvoiceController');




});


/*end database routes */





