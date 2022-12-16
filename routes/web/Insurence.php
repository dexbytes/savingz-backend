<?php

use App\Http\Livewire\Insurance\Category\Create as InsurenceCategoryCreate;
use App\Http\Livewire\Insurance\Category\Edit as InsurenceCategoryEdit;
use App\Http\Livewire\Insurance\Category\Index as InsurenceCategoryIndex;
use Illuminate\Support\Facades\Route;  
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


Route::group(['middleware' => ['auth']], function () {

      Route::get('insurence/category/index', InsurenceCategoryIndex::class)->name('insurence-category-management');
      Route::get('insurence/category/edit/{id}',InsurenceCategoryEdit::class)->name('edit-insurence-category');
      Route::get('insurence/category/create', InsurenceCategoryCreate::class)->name('add-insurence-category');
});