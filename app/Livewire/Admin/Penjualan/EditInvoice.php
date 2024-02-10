<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\HeaderPenjualan;
use Livewire\Component;

class EditInvoice extends Component
{
    public $remarkId = '';
    public $aktualId = '';
    public $noInvoice;

    public function mount($noInvoice)
    {
        $this->noInvoice = $noInvoice;
    }

    public function render()
    {
        $penjualans = HeaderPenjualan::where('no_invoice', $this->noInvoice)
            ->with(['detail_penjualan.barang', 'customer'])
            ->first();
        return view('livewire.admin.penjualan.edit-invoice', ['dataPenjualan' => $penjualans]);
    }

    public function cancel()
    {
        $this->dispatch('cancel-edit')->to(Invoice::class);
    }
}
