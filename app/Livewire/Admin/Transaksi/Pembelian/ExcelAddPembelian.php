<?php

namespace App\Livewire\Admin\Transaksi\Pembelian;

use Livewire\Attributes\On;
use Livewire\Component;

class ExcelAddPembelian extends Component
{

    public $showExcel = false;

    public function render()
    {
        return view('livewire.admin.transaksi.pembelian.excel-add-pembelian');
    }

    public function cancelExcel()
    {
        $this->dispatch('cancel-excel')->to(AddPembelian::class);
    }
}
