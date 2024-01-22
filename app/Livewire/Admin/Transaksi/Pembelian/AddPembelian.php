<?php

namespace App\Livewire\Admin\Transaksi\Pembelian;

use App\Models\Pembelian;
use Livewire\Component;

class AddPembelian extends Component
{
    public $pembelians;

    public function mount()
    {
        $this->pembelians = Pembelian::where('status', 'WAITING')
            ->with('kode_barang')
            ->get();
    }
    public function render()
    {
        return view('livewire.admin.transaksi.pembelian.add-pembelian');
    }
}
