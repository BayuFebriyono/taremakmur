<?php

use App\Livewire\Admin\MasterData\Barang;
use App\Livewire\Admin\MasterData\Customer;
use App\Livewire\Admin\MasterData\Suplier;
use App\Livewire\Admin\Pembelian\History;
use App\Livewire\Admin\Pembelian\Invoice;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/customer', Customer::class);
    Route::get('/suplier', Suplier::class);
    Route::get('/barang', Barang::class);
    Route::get('/pembelian-invoice', Invoice::class);
    Route::get('/pembelian-history', History::class);
});

Route::get('/tes', function(){
    return uniqid();
});
