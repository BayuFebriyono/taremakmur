<?php

namespace App\Livewire\Admin\Transaksi\Penjualan;

use App\Models\Penjualan;
use Livewire\Attributes\On;
use Livewire\Component;

class ListPenjualan extends Component
{

    #[On('saved')]
    public function render()
    {
        return view('livewire.admin.transaksi.penjualan.list-penjualan', [
            'penjualans' => Penjualan::latest()->get()
        ]);
    }
}
