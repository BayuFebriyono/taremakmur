<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\Barang;
use App\Models\Report;
use Livewire\Component;
use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;

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

    public function simpan()
    {
        DetailPenjualan::where('no_invoice', $this->noInvoice)
            ->where('status', 'WAITING')->delete();
        $detail = DetailPenjualan::where('no_invoice', $this->noInvoice)
            ->where('status', 'CONFIRMED')
            ->get();
        $detail->each(function ($item) {
            $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
            if ($item['jenis'] == 'dus') {
                $barang->update([
                    'stock_renteng' => $barang->stock_renteng - ($item['aktual'] * $barang->jumlah_renteng)
                ]);
                Report::create([
                    'kode_barang' => $item['kode_barang'],
                    'out' => $item['aktual'] * $barang->jumlah_renteng,
                    'harga' => $item['harga'],
                    'stock' => $barang->stock_sto
                ]);
            } else {
                $barang->update([
                    'stock_renteng' => $barang->stock_renteng - ($item['aktual'])
                ]);
                Report::create([
                    'no_invoice' => $this->noInvoice,
                    'kode_barang' => $item['kode_barang'],
                    'out' => $item['aktual'],
                    'harga' => $item['harga'],
                    'stock' => $barang->stock_sto
                ]);
            }
        });

        HeaderPenjualan::where('no_invoice', $this->noInvoice)->update([
            'status' => 'CONFIRMED'
        ]);
        $this->dispatch('cancel-edit', message : 'Berhasil dikonfirmasi', type: 'success-top')->to(Invoice::class);
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
        $this->dispatch('cancel-edit');
    }
}
