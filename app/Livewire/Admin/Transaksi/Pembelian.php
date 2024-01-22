<?php

namespace App\Livewire\Admin\Transaksi;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Pembelian')]
#[Layout('components.layouts.sidebar')]
class Pembelian extends Component
{
    public function render()
    {
        return view('livewire.admin.transaksi.pembelian');
    }
}
