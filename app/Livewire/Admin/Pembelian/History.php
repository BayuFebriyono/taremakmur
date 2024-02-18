<?php

namespace App\Livewire\Admin\Pembelian;

use Dompdf\Dompdf;
use App\Models\Barang;
use App\Models\Report;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\DetailPembelian;
use App\Models\HeaderPembelian;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.sidebar')]
#[Title('History Pembelian')]
class History extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $search = '';
    public $isEdit = false;
    public $noInvoice;

    public function render()
    {
        $pembelians = HeaderPembelian::with(['user', 'suplier'])
            ->where('no_invoice', 'like', '%' . $this->search . '%')
            ->where('status', 'CONFIRMED')
            ->latest()->paginate($this->perPage);
        return view('livewire.admin.pembelian.history', [
            'pembelians' => $pembelians
        ]);
    }

    #[On('cancel-edit')]
    public function cancel()
    {
        $this->noInvoice = null;
        $this->isEdit = false;
    }

    public function showDetail($noInvoice)
    {
        $this->noInvoice = $noInvoice;
        $this->isEdit = true;
    }

    public function delete($noInvoice)
    {
        HeaderPembelian::where('no_invoice', $noInvoice)->delete();
        $detail = DetailPembelian::where('no_invoice', $noInvoice)->get();
        $detail->each(function ($item) {

            // update stock
            $barang = Barang::where('kode_barang', $item['kode_barang'])->first();
            $barang->update([
                'stock_renteng' => $barang->stock_renteng - ($item['aktual'] * $barang->jumlah_renteng)
            ]);
        });
        DetailPembelian::where('no_invoice', $noInvoice)->delete();
        Report::where('no_invoice', $noInvoice)->delete();

        session()->flash('success', 'Data berhasil dihapus');
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
}
