<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\Barang;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.sidebar')]
#[Title('Customer Order')]
class CustomerOrder extends Component
{
    public $perPage = 10;
    public $search = '';

    public function render()
    {
        $penjualans = HeaderPenjualan::with(['user', 'customer'])
            ->where('no_invoice', 'like', '%' . $this->search . '%')
            ->where('status', 'CUSTOMER')
            ->latest()->paginate($this->perPage);
        return view('livewire.admin.penjualan.customer-order', ['penjualans' => $penjualans]);
    }

    public function delete($noInvoice)
    {
        HeaderPenjualan::where('no_invoice', $noInvoice)->delete();
        $detail = DetailPenjualan::where('no_invoice', $noInvoice)->get();
        $detail->each(function ($item) {
            $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
            if ($item['jenis'] == 'dus') {
                $barang->update([
                    'stock_bayangan' => $barang->stock_bayangan + ($item['aktual'] * $barang->jumlah_renteng)
                ]);
            } else {
                $barang->update([
                    'stock_bayangan' => $barang->stock_bayangan + ($item['aktual'])
                ]);
            }
        });
        DetailPenjualan::where('no_invoice', $noInvoice)->delete();
        session()->flash('success', 'Data berhasil dihapus');
    }

    public function generateNota($no_invoice)
    {
        $data = HeaderPenjualan::where('no_invoice', $no_invoice)->with('detail_penjualan.barang')->first();
        $pdf = Pdf::loadView('print.nota-penjualan', ['data' => $data])->setPaper('80mm', 'auto')->output();
        return response()->streamDownload(
            fn () => print($pdf),
            'nota_penjualan.pdf'
        );
    }
}
