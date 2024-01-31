<?php

namespace App\Livewire\Admin\Transaksi;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Penjualan')]
#[Layout('components.layouts.sidebar')]
class Penjualan extends Component
{
    public function render()
    {
        return view('livewire.admin.transaksi.penjualan');
    }
}
