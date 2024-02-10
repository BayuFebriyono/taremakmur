<?php

namespace App\Livewire\Admin\Penjualan;

use App\Models\DetailPenjualan;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HeaderPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;

class WaitingConfirm extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search = '';
    public function render()
    {
        $penjualans = HeaderPenjualan::with(['user', 'customer'])
            ->where('no_invoice', 'like', '%' . $this->search . '%')
            ->where('status', 'WAITING')
            ->latest()->paginate($this->perPage);
        return view('livewire.admin.penjualan.waiting-confirm', ['penjualans' => $penjualans]);
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

    public function delete($noInvoice)
    {
        DetailPenjualan::where('no_invoice', $noInvoice)->delete();
        HeaderPenjualan::where('no_invoice', $noInvoice)->delete();
    }

    public function setInvoice($noInvoice)
    {
        $this->dispatch('set-invoice', noInvoice : $noInvoice)->to(Invoice::class);
    }
}
