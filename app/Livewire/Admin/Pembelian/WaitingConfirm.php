<?php

namespace App\Livewire\Admin\Pembelian;

use Dompdf\Dompdf;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DetailPembelian;
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
        // // dd($data->toArray());
        // $pdf = Pdf::loadView('print.nota-pembelian', ['data' => $data])->setPaper('80mm', 'auto')->output();
        // return response()->streamDownload(
        //     fn () => print($pdf),
        //     'nota.pdf'
        // );

        $pdf = new Dompdf();

        $options = $pdf->getOptions();
        $pdf->setPaper(array(0, 0, 226.772, 566.929), 'portrait');

        $options->set(array(
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ));
        $pdf->setOptions($options);
        $template = view('print.nota-pembelian', ['data' => $data])->render();

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

        $pdf = Pdf::loadView('print.nota-pembelian', ['data' => $data])->setPaper([0, 0, 226.772, $docHeight])->output();
        return response()->streamDownload(
            fn () => print($pdf),
            'nota.pdf'
        );

    }

    public function delete($noInvoice)
    {
        DetailPembelian::where('no_invoice', $noInvoice)->delete();
        HeaderPembelian::where('no_invoice', $noInvoice)->delete();

        session()->flash('success', 'Data berhasil dihapus');
    }
}
