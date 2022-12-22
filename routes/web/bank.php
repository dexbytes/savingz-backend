<?php

use App\Http\Livewire\Bank\Bank\Create as BankCreate;
use App\Http\Livewire\Bank\Bank\Edit as BankEdit;
use App\Http\Livewire\Bank\Bank\Index as BankIndex;


use App\Http\Livewire\Bank\Cards\Create as CardCreate;
use App\Http\Livewire\Bank\Cards\Edit as CardEdit;
use App\Http\Livewire\Bank\Cards\Index as CardIndex;

use App\Http\Livewire\Bank\Services\Category\Create as ServiceCategoryCreate;
use App\Http\Livewire\Bank\Services\Category\Edit as ServiceCategoryEdit;
use App\Http\Livewire\Bank\Services\Category\Index as ServiceCategoryIndex;

use App\Http\Livewire\Bank\Transaction\Index as TransactionIndex;
use App\Http\Livewire\Bank\Transaction\Edit as TransactionEdit;
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

    Route::get('bank/list', BankIndex::class)->name('bank-management');
    Route::get('bank/edit/{id}', BankEdit::class)->name('edit-bank');
    Route::get('bank/create', BankCreate::class)->name('add-bank');
   
    Route::get('card/index', CardIndex::class)->name('cards-management');
    Route::get('card/edit/{id}', CardEdit::class)->name('edit-card');
    Route::get('card/create', CardCreate::class)->name('add-card');

    Route::get('service/category/index', ServiceCategoryIndex::class)->name('service-category-management');
    Route::get('service/category/edit/{id}', ServiceCategoryEdit::class)->name('edit-service-category');
    Route::get('service/category/create', ServiceCategoryCreate::class)->name('add-service-category');

    Route::get('transaction-hisotry/index', TransactionIndex::class)->name('card-transaction-management');
    Route::get('transaction-hisotry/edit/{id}' ,TransactionEdit::class)->name('edit-card-transaction');
});
