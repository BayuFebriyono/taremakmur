<?php

namespace App\Livewire\Admin\Pembelian;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HeaderPembelian;
use Barryvdh\DomPDF\Facade\Pdf;

class WaitingConfirm extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search = '';
    public function render()
    {
        $pembelians = HeaderPembelian::with(['user', 'suplier'])
            ->where('no_invoice', 'like', '%' . $this->search . '%')
            ->where('status', 'WAITING')
            ->latest()->paginate($this->perPage);
        return view('livewire.admin.pembelian.waiting-confirm', ['pembelians' => $pembelians]);
    }

    public function setInvoice($noInvoice)
    {
        $this->dispatch('set-invoice', $noInvoice)->to(Invoice::class);
    }

    public function generateNota($no_invoice)
    {
        $data = HeaderPembelian::where('no_invoice', $no_invoice)->with('detail_pembelian')->first();
        // dd($data->toArray());
        $pdf = Pdf::loadView('print.nota-pembelian', ['data' => $data])->setPaper('80mm', 'auto')->output();
        return response()->streamDownload(
            fn () => print($pdf),
            'nota.pdf'
        );
    }


}
