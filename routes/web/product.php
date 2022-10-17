<?php


use Illuminate\Support\Facades\Route;


use App\Http\Livewire\Product\Index as ProductIndex;
use App\Http\Livewire\Product\Category\Edit as CategoryEdit;
use App\Http\Livewire\Product\Category\Create as CategoryCreate;
use App\Http\Livewire\Product\Category\Index as CategoryIndex;
use App\Http\Livewire\Product\Addon\Index as AddonOptionsIndex;
use App\Http\Livewire\Tags\Index as TagsIndex;
use App\Http\Livewire\Tags\Create as TagsCreate;
use App\Http\Livewire\Tags\Edit as TagsEdit;
 
 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
Route::group(['middleware' => 'auth'], function () {

    Route::get('products/list', ProductIndex::class)->name('product-management');
    // Route::get('stores/edit/{id}', ProductEdit::class)->name('edit-product');
    // Route::get('stores/create', ProductCreate::class)->name('add-product');

    Route::get('products/category/create', CategoryCreate::class)->name('add-category');
    Route::get('products/category/edit/{id}',  CategoryEdit::class)->name('edit-category');
    Route::get('products/category', CategoryIndex::class)->name('product-category-management');
    Route::get('products/addons', AddonOptionsIndex::class)->name('product-addon-management'); 
    Route::get('products/tags', TagsIndex::class)->name('product-tag-management');
    Route::get('products/tags/create', TagsCreate::class)->name('new-product-tag');
    Route::get('products/tags/edit/{id}', TagsEdit::class)->name('edit-product-tag');
    
 
});