<?php

namespace App\Livewire\Admin\Transaksi\Penjualan;

use Livewire\Component;

class AddPenjualan extends Component
{

    // utils
    public $showModal = false;


    public function render()
    {
        return view('livewire.admin.transaksi.penjualan.add-penjualan');
    }

    public function add()
    {
        $this->showModal = true;
    }

    public function cancel()
    {
        $this->showModal = false;
    }
}
