<?php

use App\Livewire\Admin\MasterData\Barang;
use App\Livewire\Admin\MasterData\Customer;
use App\Livewire\Admin\MasterData\Suplier;
use App\Livewire\Admin\Transaksi\Pembelian;
use App\Livewire\Admin\Transaksi\Penjualan;
use App\Livewire\Admin\Transaksi\Report\QtyReport;
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
    Route::get('/pembelian', Pembelian::class);
    Route::get('/penjualan', Penjualan::class);
    Route::get('/qty-report', QtyReport::class);
});

Route::get('/tes', function(){
    return uniqid();
});
