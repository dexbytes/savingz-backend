<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Investment\Create as InvestmentTypesCreate;
use App\Http\Livewire\Investment\Edit as InvestmentTypesEdit;
use App\Http\Livewire\Investment\Index as InvestmentTypesIndex;
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
    Route::get('investment-types', InvestmentTypesIndex::class)->name('investment-type-management');
    Route::get('investment-types/edit/{id}', InvestmentTypesEdit::class)->name('edit-investment-type');
    Route::get('investment-types/create', InvestmentTypesCreate::class)->name('add-investment-type');
});