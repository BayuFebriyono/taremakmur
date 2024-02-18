<?php

namespace App\Livewire\Admin\Penjualan;

use Dompdf\Dompdf;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\DetailPenjualan;
use App\Models\HeaderPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.sidebar')]
#[Title('History Penjualan')]
class History extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $noInvoice;
    public $isEdit = false;

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

    public function showDetail($noInvoice)
    {
        $this->noInvoice = $noInvoice;
        $this->isEdit = true;
    }

    #[On('cancel-edit')]
    public function cancel(){
        $this->noInvoice = null;
        $this->isEdit = false;
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
        $pdf = new Dompdf();

        $options = $pdf->getOptions();
        $pdf->setPaper(array(0, 0, 226.772, 566.929), 'portrait');

        $options->set(array(
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ));
        $pdf->setOptions($options);
        $template = view('print.nota-penjualan', ['data' => $data])->render();

        $pdf->loadHtml($template);

        $GLOBALS['bodyHeight'] = 0;

        $pdf->setCallbacks([
            'myCallbacks' => [
                'event' => 'end_frame',
                'f' => function ($frame) {
                    $node = $frame->get_node();

                    if (strtolower($node->nodeName) === "body") {
                        $padding_box = $frame->get_padding_box();
                        $GLOBALS['bodyHeight'] += $padding_box['h'];
                    }
                }
            ]
        ]);

        $pdf->render();
        unset($pdf);
        $docHeight = $GLOBALS['bodyHeight'] + 100;
        $pdf = Pdf::loadView('print.nota-penjualan', ['data' => $data])->setPaper([0, 0, 226.772, $docHeight])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            'nota_penjualan.pdf'
        );
    }
}
