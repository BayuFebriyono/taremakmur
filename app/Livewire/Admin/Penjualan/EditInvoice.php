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
    public $jatuhTempo = null;
    public $jenisPembayaran = "";

    public function mount($noInvoice)
    {
        $this->noInvoice = $noInvoice;
        $header = HeaderPenjualan::where('no_invoice', $noInvoice)->first();
        $this->jatuhTempo = $header->jatuh_tempo;
        $this->jenisPembayaran = $header->jenis_pembayaran;
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

    public function waiting($id){
        DetailPenjualan::find($id)->update([
            'status' => 'WAITING'
        ]);
    }

    public function confirmed($id){
        DetailPenjualan::find($id)->update([
            'status' => 'CONFIRMED'
        ]);
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
        $deletedDetail =  DetailPenjualan::where('no_invoice', $this->noInvoice)
            ->where('status', 'WAITING')->get();

        if ($deletedDetail->count()) {
            // kembalikan stok bayangan untuk barang yang dicancel
            $deletedDetail->each(function ($item) {
                $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
                if ($item['jenis'] == 'dus') {
                    $barang->update([
                        'stock_bayangan' => $barang->stock_renteng + ($item['aktual'] * $barang->jumlah_renteng)
                    ]);
                } else {
                    $barang->update([
                        'stock_bayangan' => $barang->stock_renteng + ($item['aktual'])
                    ]);
                }
            });

            // Hapus Barang dari detail order
            $deletedDetail->delete();
        }


        $detail = DetailPenjualan::where('no_invoice', $this->noInvoice)
            ->where('status', 'CONFIRMED')
            ->get();
        $header = HeaderPenjualan::where('no_invoice', $this->noInvoice)->first();

        if ($header->status != 'CONFIRMED') {
            $detail->each(function ($item) {
                $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
                if ($item['jenis'] == 'dus') {
                    $barang->update([
                        'stock_renteng' => $barang->stock_renteng - ($item['aktual'] * $barang->jumlah_renteng)
                    ]);
                    Report::create([
                        'no_invoice' => $this->noInvoice,
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
        }

        HeaderPenjualan::where('no_invoice', $this->noInvoice)->update([
            'status' => 'CONFIRMED',
            'jatuh_tempo' => $this->jatuhTempo,
            'jenis_pembayaran' => $this->jenisPembayaran
        ]);
        $this->jatuhTempo = null;
        $this->dispatch('cancel-edit', message: 'Berhasil dikonfirmasi', type: 'success-top')->to(Invoice::class);
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
