<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\DetailPembelian;
use App\Models\HeaderPembelian;
use Livewire\Component;

class EditInvoice extends Component
{
    public $aktualId;
    public $remarkId;
    public $noInvoice;

    public $remark;
    public $aktual;

    public function mount($noInvoice)
    {
        $this->noInvoice = $noInvoice;
    }

    public function render()
    {
        $pembelian = HeaderPembelian::where('no_invoice', $this->noInvoice)->with('detail_pembelian.barang')->first();
        return view('livewire.admin.pembelian.edit-invoice', [
            'dataPembelian' => $pembelian
        ]);
    }

    public function confirmed($id)
    {
        DetailPembelian::find($id)->update([
            'status' => 'CONFIRMED'
        ]);
    }

    public function waiting($id)
    {
        DetailPembelian::find($id)->update([
            'status' => 'WAITING'
        ]);
    }

    public function showAktual($id)
    {
        $this->aktualId = $id;
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

    public function updateRemark()
    {
        DetailPembelian::find($this->remarkId)->update([
            'remark' => $this->remark
        ]);
        $this->remarkId = '';
        $this->remark = '';
    }
    public function updateAktual()
    {
        DetailPembelian::find($this->aktualId)->update([
            'aktual' => $this->aktual
        ]);
        $this->aktualId = '';
        $this->aktual = '';
    }
}
