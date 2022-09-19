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

Route::get('/edit/{netmri}/{scriptId}/{language}', \App\Http\Livewire\ScriptEdit::class)->name('script.edit');
Route::get('/', \App\Http\Livewire\ScriptList::class)->name('script.list');
