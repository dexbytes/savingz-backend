<?php

use App\Http\Livewire\Services\Category\Create as ServiceCategoryCreate;
use App\Http\Livewire\Services\Category\Edit as ServiceCategoryEdit;
use App\Http\Livewire\Services\Category\Index as ServiceCategoryIndex;
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

    Route::get('services/category/index', ServiceCategoryIndex::class)->name('service-category-management');
     Route::get('services/category/edit/{id}', ServiceCategoryEdit::class)->name('edit-service-category');
     Route::get('services/category/create', ServiceCategoryCreate::class)->name('add-service-category');
});
