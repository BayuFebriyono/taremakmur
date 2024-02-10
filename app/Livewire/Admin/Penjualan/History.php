<?php

namespace App\Livewire\Admin\Penjualan;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;

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
            ->where('status', 'CONFIRMED')
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
