<?php

namespace App\Livewire\Admin\Transaksi\Pembelian;

use App\Models\Pembelian;
use App\Models\Suplier;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ExcelAddPembelian extends Component
{
    use WithFileUploads;

    public $excel;


    public function render()
    {
        return view('livewire.admin.transaksi.pembelian.excel-add-pembelian');
    }

    public function cancelExcel($message = '')
    {
        $this->dispatch('cancel-excel', message: $message)->to(AddPembelian::class);
    }

    public function store()
    {
        $this->validate([
            'excel' => 'required'
        ]);
     

        $fileExstension = $this->excel->getClientOriginalExtension();
        $allowedExt = ['xls', 'csv', 'xlsx'];

        if (in_array($fileExstension, $allowedExt)) {
            $path = $this->excel->storeAs('temp', 'uploaded_file.xlsx', 'local');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path("app/{$path}"));

            $data = $spreadsheet->getActiveSheet()->removeRow(1, 4)->toArray();
            foreach ($data as $row) {
                $suplier = Suplier::select('id')->where('nama', $row[0])->first();

                Pembelian::create([
                    'suplier_id' => $suplier->id,
                    'no_invoice' => $row[1],
                    'kode_barang' => $row[2],
                    'qty' => $row[3],
                    'aktual' => $row[3],
                    'harga' => $row[4],
                    'diskon' => $row[5]
                ]);
            }
            $this->cancelExcel('Data berhasil diimport');
        } else {
            $this->cancelExcel('Format file tidak sesuai');
        }
    }
}
