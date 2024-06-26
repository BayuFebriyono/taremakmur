<?php

namespace App\Livewire\Admin\Excel;

use App\Models\Barang;
use App\Models\Suplier;
use Livewire\Component;
use Livewire\WithFileUploads;

class BarangExcel extends Component
{
    use WithFileUploads;

    public $excel;
    public function render()
    {
        return view('livewire.admin.excel.barang-excel');
    }

    public function cancelExcel($message = '')
    {
        $this->dispatch('cancelExcelBarang', message: $message);
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

                if(!$suplier){
                    $suplier = Suplier::create([
                        'nama' => $row[0],
                        'nama_barang' => '-',
                        'suplier' => $row[0],
                        'satuan' => 'pcs',
                        'unit' => '1'
                    ]);
                }

                $barang = Barang::where('kode_barang', $row[1])->first();

                if ($barang) {
                    $barang->update([
                        'suplier_id' => $suplier->id,
                        'kode_barang' => $row[1],
                        'nama_barang' => $row[2],
                        'cash_dus' => $row[3],
                        'cash_pack' => $row[4],
                        'harga_beli_dus' => $row[5],
                        'harga_beli_pack' => $row[6],
                        'kredit_dus' => $row[7],
                        'kredit_pack' => $row[8],
                        'diskon' => $row[9],
                        'jumlah_renteng' => $row[10],
                        'jenis' => $row[11]
                    ]);
                } else {
                    Barang::create([
                        'suplier_id' => $suplier->id,
                        'kode_barang' => $row[1],
                        'nama_barang' => $row[2],
                        'cash_dus' => $row[3],
                        'cash_pack' => $row[4],
                        'harga_beli_dus' => $row[5],
                        'harga_beli_pack' => $row[6],
                        'kredit_dus' => $row[7],
                        'kredit_pack' => $row[8],
                        'diskon' => $row[9],
                        'jumlah_renteng' => $row[10],
                        'jenis' => $row[11]
                    ]);
                }
            }

            $this->cancelExcel('Data berhasil diimport');
        } else {
            $this->cancelExcel('Format file tidak didukung');
        }
    }
}

