<?php

use  App\Http\Livewire\Import\Create as ImportCreate;
use App\Http\Livewire\Import\View as ImportView;
use App\Http\Livewire\Import\Index as ImportIndex;
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

    Route::get('import/files', ImportIndex::class)->name('import-files-management');
    Route::get('import/view/{id}/{status?}', ImportView::class)->name('import-files-view');
    Route::get('import/file/create/{module?}', ImportCreate::class)->name('import-file');

});
