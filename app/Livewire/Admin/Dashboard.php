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
        $hargaPenjualan = 0;
        $hargaPembelian = 0;
        $hargaJatuhTempo = 0;
        $pembelian = HeaderPembelian::with(['suplier', 'detail_pembelian'])->where('lunas', false)
            ->where('status', 'CONFIRMED')
            ->latest()->get();
        $penjualan = HeaderPenjualan::with(['customer', 'detail_penjualan'])->where('lunas', false)
            ->where('status', 'CONFIRMED')
            ->latest()->get();
        $jatuhTempo = HeaderPenjualan::with(['customer', 'detail_penjualan'])
            ->whereDate('jatuh_tempo', '<', now()->toDateString())
            ->where('lunas', false)
            ->where('status', 'CONFIRMED')
            ->latest()->get();

        foreach ($pembelian as $detail) {
            $hargaPembelian += $detail->detail_pembelian->sum('harga');
        }
        foreach ($penjualan  as $detail) {
            $hargaPenjualan += $detail->detail_penjualan->sum('harga');
        }
        foreach($jatuhTempo as $detail){
            $hargaJatuhTempo += $detail->detail_penjualan->sum('harga');
        }

        return view('livewire.admin.dashboard', [
            'pembelians' => $pembelian,
            'penjualans' => $penjualan,
            'jatuhTempo' => $jatuhTempo,
            'hargaPembelian' => $hargaPembelian,
            'hargaPenjualan' => $hargaPenjualan,
            'hargaJatuhTempo' => $hargaJatuhTempo
        ]);
    }
}
