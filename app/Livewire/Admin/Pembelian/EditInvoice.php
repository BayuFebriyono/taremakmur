<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\HeaderPembelian;
use Livewire\Component;

class EditInvoice extends Component
{
    public $aktualId;
    public $remarkId;
    public $noInvoice;

    public function mount($noInvoice){
        $this->noInvoice = $noInvoice;

    }

    public function render()
    {
        $pembelian = HeaderPembelian::where('no_invoice', $this->noInvoice)->with('detail_pembelian.barang')->first();
        return view('livewire.admin.pembelian.edit-invoice',[
            'dataPembelian' => $pembelian
        ]);
    }
}
