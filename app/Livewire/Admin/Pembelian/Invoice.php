<?php

namespace App\Livewire\Admin\Pembelian;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
#[Title('Invoice Pembelian')]
class Invoice extends Component
{
    public function render()
    {
        return view('livewire.admin.pembelian.invoice');
    }
}
