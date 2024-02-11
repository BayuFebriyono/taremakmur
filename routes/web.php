<?php

use App\Livewire\Admin\MasterData\Barang;
use App\Livewire\Admin\MasterData\Customer;
use App\Livewire\Admin\MasterData\Suplier;
use App\Livewire\Admin\Pembelian\History;
use App\Livewire\Admin\Pembelian\Invoice;
use App\Livewire\Admin\Penjualan\CustomerOrder;
use App\Livewire\Admin\Penjualan\History as PenjualanHistory;
use App\Livewire\Admin\Penjualan\Invoice as PenjualanInvoice;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\LoginCustomer;
use App\Livewire\Customer\GantiPassword;
use App\Livewire\Customer\MyOrder;
use App\Livewire\Customer\Order;
use App\Livewire\Report\ReportQty;
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
Route::get('/login-customer', LoginCustomer::class);

// admin
Route::middleware('role:super_admin')->group(function () {
    Route::get('/customer', Customer::class);
    Route::get('/suplier', Suplier::class);
    Route::get('/barang', Barang::class);
    Route::get('/pembelian-invoice', Invoice::class);
    Route::get('/pembelian-history', History::class);
    Route::get('/penjualan-invoice', PenjualanInvoice::class);
    Route::get('/penjualan-history', PenjualanHistory::class);
    Route::get('/persetujuan', CustomerOrder::class);

    Route::get('/report', ReportQty::class);
});

// customer
Route::middleware('customer')->group(function (){
    Route::get('/customer-order', Order::class);
    Route::get('/ganti-password', GantiPassword::class);
    Route::get('/my-order', MyOrder::class);
});

Route::get('/tes', function(){
    return uniqid();
});
