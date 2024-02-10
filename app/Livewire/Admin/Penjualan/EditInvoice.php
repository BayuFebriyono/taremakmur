<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;
use Livewire\Component;

class EditInvoice extends Component
{
    public $remarkId = '';
    public $aktualId = '';
    public $noInvoice;
    public $aktual = '';
    public $remark = '';

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

    public function showAktual($id)
    {
        $this->aktualId = $id;
    }

    public function updateAktual()
    {
        
        DetailPenjualan::find($this->aktualId)
            ->update([
                'aktual' => $this->aktual
            ]);
        $this->aktualId = '';
        $this->aktual = '';
    }

    public function updateRemark()
    {
        DetailPenjualan::find($this->remarkId)
            ->update([
                'remark' => $this->remark
            ]);
        $this->remarkId = '';
        $this->remark = '';
    }

    public function cancelAktual()
    {
        $this->aktualId = '';
    }

    public function showRemark($id)
    {
        $this->remarkId = $id;
    }

    public function cancelRemark()
    {
        $this->remarkId = '';
    }

    public function cancel()
    {
        $this->dispatch('cancel-edit')->to(Invoice::class);
    }
}
