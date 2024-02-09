<?php

namespace App\Livewire\Admin\Pembelian;

use App\Models\HeaderPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.sidebar')]
#[Title('History Pembelian')]
class History extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search = '';

    public function render()
    {
        $pembelians = HeaderPembelian::with(['user', 'suplier'])->latest()->paginate($this->perPage);
        return view('livewire.admin.pembelian.history', [
            'pembelians' => $pembelians
        ]);
    }

    public function generateNota($no_invoice)
    {
        $data = HeaderPembelian::where('no_invoice', $no_invoice)->with('detail_pembelian')->first();
// dd($data->toArray());
        $pdf = Pdf::loadView('print.nota-pembelian', ['data' => $data])->setPaper('80mm', 'auto')->output();
        return response()->streamDownload(
            fn() => print($pdf),
            'file_name.pdf'
        );

    }
}
