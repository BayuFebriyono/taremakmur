<?php

namespace App\Livewire\Admin\Transaksi\Report;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\QtyReport as ModelQtyReport;

#[Layout('components.layouts.sidebar')]
#[Title('Qty Report')]
class QtyReport extends Component
{
    use WithPagination;
    public $perPage = 10;
    public function render()
    {
        return view('livewire.admin.transaksi.report.qty-report',[
            'reports' => ModelQtyReport::latest()->paginate($this->perPage)
        ]);
    }
}
