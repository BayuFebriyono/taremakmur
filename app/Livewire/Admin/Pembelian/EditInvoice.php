<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\Barang;
use App\Models\Report;
use Livewire\Component;
use App\Models\DetailPembelian;
use App\Models\HeaderPembelian;

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

    public function cancel()
    {
        $this->dispatch('cancel-edit')->to(Invoice::class);
    }

    public function simpan()
    {
        DetailPembelian::where('no_invoice', $this->noInvoice)
            ->where('status', 'WAITING')
            ->delete();
        $detail = DetailPembelian::where('no_invoice', $this->noInvoice)
            ->where('status', 'CONFIRMED')
            ->get();
        $detail->each(function ($item) {

            // update stock
            $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
            $barang->update([
                'stock_renteng' => $barang->stock_renteng + ($item['aktual'] * $barang->jumlah_renteng)
            ]);
            Report::create([
                'kode_barang' => $item['kode_barang'],
                'in' => $item['aktual'] * $barang->jumlah_renteng,
                'harga' => $item['harga'],
                'stock' => $barang->stock_sto
            ]);
        });

        HeaderPembelian::where('no_invoice', $this->noInvoice)->update([
            'status' => 'CONFIRMED'
        ]);
        $this->dispatch('cancel-edit', message : 'Berhasil dikonfirmasi', type: 'success-top')->to(Invoice::class);
    }
}
