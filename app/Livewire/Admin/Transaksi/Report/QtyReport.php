<?php

namespace App\Livewire\Admin\Transaksi\Report;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.sidebar')]
#[Title('Qty Report')]
class QtyReport extends Component
{
    public function render()
    {
        return view('livewire.admin.transaksi.report.qty-report');
    }
}
