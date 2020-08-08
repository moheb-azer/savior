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

    /**/

    /* ajax crud routes */

    Route::resource('/customers', 'CustomerController');

    Route::resource('/suppliers', 'SupplierController');

    Route::resource('/categories', 'CategoryController');

    Route::resource('/subcategories', 'SubcategoryController');

    Route::resource('/brands', 'BrandController');

    Route::resource('/products', 'ProductController');



    Route::get('/cat/show', 'SubcategoryController@show')->name('show_cat');
    Route::get('/subcat/show', 'ProductController@subcategory')->name('show_subcat');
    Route::get('/brand/show', 'ProductController@brand')->name('show_brand');




});


/*end database routes */


/* Auth routes */
Auth::routes();



