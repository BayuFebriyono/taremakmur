<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('History Penjualan')]
class History extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public function render()
    {
        $penjualans = HeaderPenjualan::with(['user', 'customer'])
            ->where('no_invoice', 'like', '%' . $this->search . '%')
            ->latest()->paginate($this->perPage);
        return view('livewire.admin.penjualan.history', [
            'penjualans' => $penjualans
        ]);
    }

    public function delete($noInvoice)
    {
        DetailPenjualan::where('no_invoice', $noInvoice)->delete();
        HeaderPenjualan::where('no_invoice', $noInvoice)->delete();
        session()->flash('success', 'Data berhasil dihapus');
    }
}
