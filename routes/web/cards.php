<?php

use App\Http\Livewire\Cards\Create as CardCreate;
use App\Http\Livewire\Cards\Edit as CardEdit;
use App\Http\Livewire\Cards\Index as CardIndex;
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

    Route::get('cards/index', CardIndex::class)->name('cards-management');
     Route::get('cards/edit/{id}', CardEdit::class)->name('edit-card');
     Route::get('cards/create', CardCreate::class)->name('add-card');
});
