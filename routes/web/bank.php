<?php

use App\Http\Livewire\Bank\Create as BankCreate;
use App\Http\Livewire\Bank\Edit as BankEdit;
use App\Http\Livewire\Bank\Index as BankIndex;
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

    Route::get('bank', BankIndex::class)->name('bank-management');
    Route::get('bank/edit/{id}', BankEdit::class)->name('edit-bank');
     Route::get('bank/create', BankCreate::class)->name('add-bank');
});
