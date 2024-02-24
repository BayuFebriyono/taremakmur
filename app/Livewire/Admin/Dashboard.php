<?php

namespace App\Livewire\Admin;

use App\Models\HeaderPembelian;
use App\Models\HeaderPenjualan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
#[Layout('components.layouts.sidebar')]
class Dashboard extends Component
{
    public function render()
    {
        $pembelian = HeaderPembelian::with(['suplier', 'detail_pembelian'])->where('lunas', false)
            ->latest()->get();
        $penjualan = HeaderPenjualan::with(['customer', 'detail_penjualan'])->where('lunas', false)
            ->latest()->get();
        $jatuhTempo = HeaderPenjualan::with(['customer', 'detail_penjualan'])
            ->whereDate('jatuh_tempo', '<', now()->toDateString())
            ->where('lunas', false)
            ->latest()->get();
        return view('livewire.admin.dashboard', [
            'pembelians' => $pembelian,
            'penjualans' => $penjualan,
            'jatuhTempo' => $jatuhTempo
        ]);
    }
}
