<?php

namespace App\Livewire\Admin\Penjualan;

use Dompdf\Dompdf;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DetailPenjualan;
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
